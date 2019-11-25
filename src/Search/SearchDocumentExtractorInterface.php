<?php declare(strict_types=1);

namespace Demontpx\RigidSearchBundle\Search;

use Demontpx\RigidSearchBundle\Model\Document;

/**
 * @copyright 2015 Bert Hekman
 */
interface SearchDocumentExtractorInterface
{
    /**
     * @param object $item
     */
    public function extractDocument($item): Document;

    /**
     * @param object $item
     */
    public function extractId($item): int;
}
