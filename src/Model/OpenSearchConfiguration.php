<?php

namespace Demontpx\RigidSearchBundle\Model;

/**
 * Class OpenSearchConfiguration
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
class OpenSearchConfiguration
{
    /** @var string */
    private $shortName;

    /** @var string */
    private $description;

    /** @var string */
    private $tags;

    /** @var string */
    private $contact;

    /**
     * @param string $shortName
     * @param string $description
     * @param string $tags
     * @param string $contact
     */
    public function __construct($shortName, $description, $tags, $contact)
    {
        $this->shortName = $shortName;
        $this->description = $description;
        $this->tags = $tags;
        $this->contact = $contact;
    }

    /**
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }
}
