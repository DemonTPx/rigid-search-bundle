<?php

namespace Demontpx\RigidSearchBundle\Model;

/**
 * @copyright 2015 Bert Hekman
 */
class Field
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $text;

    /** @var float */
    protected $weight;

    public function __construct(string $name, string $text, float $weight)
    {
        $this->name = $name;
        $this->text = $text;
        $this->weight = $weight;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight)
    {
        $this->weight = $weight;
    }
}
