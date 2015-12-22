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

    /**
     * @param IndexInterface           $index
     * @param ItemSearchManagerFactory $itemManagerFactory
     */
    public function __construct(IndexInterface $index, ItemSearchManagerFactory $itemManagerFactory)
    {
        $this->index = $index;
        $this->itemManagerFactory = $itemManagerFactory;
    }

    /**
     * @param ProcessorInterface $processor
     */
    public function registerProcessor(ProcessorInterface $processor)
    {
        $this->documentProcessorList[] = $processor;
    }

    /**
     * @param object $item
     */
    public function index($item)
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
    public function remove($item)
    {
        $manager = $this->itemManagerFactory->getByClass(get_class($item));
        $this->index->remove($manager->getType(), $item->getId());
    }

    /**
     * @param string $class
     * @param int    $id
     */
    public function removeByClassAndId($class, $id)
    {
        $manager = $this->itemManagerFactory->getByClass($class);
        $this->index->remove($manager->getType(), $id);
    }

    /**
     * @param string $query
     *
     * @return int
     */
    public function count($query)
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
    public function search($query, $offset = 0, $limit = 10)
    {
        $tokenList = $this->createTokenList($query);

        return $this->index->search($tokenList, $offset, $limit);
    }

    private function createTokenList($query)
    {
        $tokenList = explode(' ', $query);

        $tokenList = array_filter($tokenList, function($v) {
            return ! empty($v);
        });

        if (empty($tokenList)) {
            return [];
        }

        return $tokenList;
    }

    public function reindex($type)
    {
        $manager = $this->itemManagerFactory->getByType($type);
        $this->reindexByItemManager($manager);
    }

    public function reindexAll()
    {
        foreach ($this->itemManagerFactory->getAll() as $manager) {
            $this->reindexByItemManager($manager);
        }
    }

    private function reindexByItemManager(ItemSearchManagerInterface $manager)
    {
        $this->index->removeType($manager->getType());

        foreach ($manager->fetchAll() as $item) {
            $this->index($item);
        }
    }
}
