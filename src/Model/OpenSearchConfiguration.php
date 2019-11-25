<?php declare(strict_types=1);

namespace Demontpx\RigidSearchBundle\Model;

/**
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

    public function __construct(string $shortName, string $description, string $tags, string $contact)
    {
        $this->shortName = $shortName;
        $this->description = $description;
        $this->tags = $tags;
        $this->contact = $contact;
    }

    public function getShortName(): string
    {
        return $this->shortName;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTags(): string
    {
        return $this->tags;
    }

    public function getContact(): string
    {
        return $this->contact;
    }
}
