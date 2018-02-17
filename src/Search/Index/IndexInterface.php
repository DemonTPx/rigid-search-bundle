<?php

namespace Demontpx\RigidSearchBundle\Search\Index;

use Demontpx\RigidSearchBundle\Model\Document;
use Demontpx\RigidSearchBundle\Model\ScoredDocument;

/**
 * @copyright 2015 Bert Hekman
 */
interface IndexInterface
{
    public function add(string $type, int $id, Document $document): void;

    public function remove(string $type, int $id): void;

    public function removeType(string $type): void;

    public function removeAll(): void;

    /**
     * @param string[] $tokenList
     */
    public function count(array $tokenList): int;

    /**
     * @param string[] $tokenList
     *
     * @return ScoredDocument[]
     */
    public function search(array $tokenList, int $offset = 0, int $limit = 10): array;
}
