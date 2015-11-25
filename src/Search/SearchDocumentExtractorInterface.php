<?php

namespace Demontpx\RigidSearchBundle\Search;

use Demontpx\RigidSearchBundle\Model\Document;

/**
 * Interface SearchDocumentExtractorInterface
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
interface SearchDocumentExtractorInterface
{
    /**
     * @param SearchableItemInterface $item
     *
     * @return Document
     */
    public function extractDocument(SearchableItemInterface $item);
}
