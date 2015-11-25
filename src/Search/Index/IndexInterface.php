<?php

namespace Demontpx\RigidSearchBundle\Search\Index;

use Demontpx\RigidSearchBundle\Model\Document;
use Demontpx\RigidSearchBundle\Model\ScoredDocument;

/**
 * Interface IndexInterface
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
interface IndexInterface
{
    /**
     * @param string   $type
     * @param int      $id
     * @param Document $document
     */
    public function add($type, $id, Document $document);

    /**
     * @param string $type
     * @param int    $id
     */
    public function remove($type, $id);

    /**
     * @param string $type
     */
    public function removeType($type);

    public function removeAll();

    /**
     * @param array $tokenList
     *
     * @return int
     */
    public function count(array $tokenList);

    /**
     * @param array $tokenList
     * @param int   $offset
     * @param int   $limit
     *
     * @return ScoredDocument[]
     */
    public function search(array $tokenList, $offset = 0, $limit = 10);
}
