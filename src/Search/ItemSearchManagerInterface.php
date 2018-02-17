<?php

namespace Demontpx\RigidSearchBundle\Search;

/**
 * @copyright 2015 Bert Hekman
 */
interface ItemSearchManagerInterface
{
    /**
     * Returns the classname of the search item
     */
    public function getClass(): string;

    /**
     * Returns the short type name of the type of the items which is used to index and locate the items.
     * Examples: news, show, link, portfolio_project
     */
    public function getType(): string;

    public function getDocumentExtractor(): SearchDocumentExtractorInterface;

    public function fetchAll(): array;
}
