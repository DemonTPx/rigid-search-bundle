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

    public function __construct(string $query)
    {
        $this->query = $query;
    }

    public function __toString()
    {
        return $this->query;
    }
}
