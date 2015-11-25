<?php

namespace Demontpx\RigidSearchBundle\Model;

/**
 * Class SearchQuery
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
class SearchQuery
{
    /** @var string */
    private $query;

    /**
     * @param string $query
     */
    public function __construct($query)
    {
        $this->query = $query;
    }

    public function __toString()
    {
        return $this->query;
    }
}
