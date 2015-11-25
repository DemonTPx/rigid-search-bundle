<?php

namespace Demontpx\RigidSearchBundle\Search;

/**
 * Interface ItemSearchManagerInterface
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
interface ItemSearchManagerInterface
{
    /**
     * Returns the classname of the search item
     *
     * @return string
     */
    public function getClass();

    /**
     * Returns the short type name of the type of the items which is used to index and locate the items.
     * Examples: news, show, link, portfolio_project
     *
     * @return string
     */
    public function getType();

    /**
     * @return SearchDocumentExtractorInterface
     */
    public function getDocumentExtractor();

    /**
     * @return SearchableItemInterface[]
     */
    public function fetchAll();
}
