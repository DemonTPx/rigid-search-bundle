<?php

namespace Demontpx\RigidSearchBundle\Search;

use Demontpx\RigidSearchBundle\Model\ScoredDocument;
use Demontpx\RigidSearchBundle\Search\Index\IndexInterface;
use Demontpx\RigidSearchBundle\Search\Processor\ProcessorInterface;

/**
 * Class SearchManager
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
class SearchManager
{
    /** @var IndexInterface */
    private $index;

    /** @var ItemSearchManagerFactory */
    private $itemManagerFactory;

    /** @var ProcessorInterface[] */
    private $documentProcessorList = [];

    public function __construct(IndexInterface $index, ItemSearchManagerFactory $itemManagerFactory)
    {
        $this->index = $index;
        $this->itemManagerFactory = $itemManagerFactory;
    }

    public function registerProcessor(ProcessorInterface $processor): void
    {
        $this->documentProcessorList[] = $processor;
    }

    /**
     * @param object $item
     */
    public function index($item): void
    {
        $manager = $this->itemManagerFactory->getByClass(get_class($item));
        $documentExtractor = $manager->getDocumentExtractor();

        $document = $documentExtractor->extractDocument($item);

        foreach ($this->documentProcessorList as $processor) {
            $processor->process($document, $manager->getType());
        }

        $this->index->add($manager->getType(), $item->getId(), $document);
    }

    /**
     * @param object $item
     */
    public function remove($item): void
    {
        $manager = $this->itemManagerFactory->getByClass(get_class($item));
        $this->index->remove($manager->getType(), $item->getId());
    }

    public function removeByClassAndId(string $class, int $id): void
    {
        $manager = $this->itemManagerFactory->getByClass($class);
        $this->index->remove($manager->getType(), $id);
    }

    public function count(string $query): int
    {
        $tokenList = $this->createTokenList($query);

        return $this->index->count($tokenList);
    }

    /**
     * @param string $query
     * @param int    $offset
     * @param int    $limit
     *
     * @return ScoredDocument[]
     */
    public function search(string $query, int $offset = 0, int $limit = 10): array
    {
        $tokenList = $this->createTokenList($query);

        return $this->index->search($tokenList, $offset, $limit);
    }

    private function createTokenList(string $query): array
    {
        $tokenList = explode(' ', $query);

        $tokenList = array_filter($tokenList, function ($v) {
            return ! empty($v);
        });

        if (empty($tokenList)) {
            return [];
        }

        return $tokenList;
    }

    public function reindex(string $type): void
    {
        $manager = $this->itemManagerFactory->getByType($type);
        $this->reindexByItemManager($manager);
    }

    public function reindexAll(): void
    {
        foreach ($this->itemManagerFactory->getAll() as $manager) {
            $this->reindexByItemManager($manager);
        }
    }

    private function reindexByItemManager(ItemSearchManagerInterface $manager): void
    {
        $this->index->removeType($manager->getType());

        foreach ($manager->fetchAll() as $item) {
            $this->index($item);
        }
    }
}
