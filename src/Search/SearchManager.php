<?php declare(strict_types=1);

namespace Demontpx\RigidSearchBundle\Search;

use Demontpx\RigidSearchBundle\Model\ScoredDocument;
use Demontpx\RigidSearchBundle\Search\Index\IndexInterface;
use Demontpx\RigidSearchBundle\Search\Processor\ProcessorInterface;

/**
 * @copyright 2015 Bert Hekman
 */
class SearchManager
{
    private IndexInterface $index;
    private ItemSearchManagerFactory $itemManagerFactory;
    /** @var ProcessorInterface[] */
    private array $documentProcessorList = [];

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
     * @return ScoredDocument[]
     */
    public function search(string $query, int $offset = 0, int $limit = 10): array
    {
        $tokenList = $this->createTokenList($query);

        return $this->index->search($tokenList, $offset, $limit);
    }

    private function createTokenList(string $query): array
    {
        $tokenList = array_filter(explode(' ', $query), fn ($v) => ! empty($v));

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
