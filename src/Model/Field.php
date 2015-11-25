<?php

namespace Demontpx\RigidSearchBundle\Model;

/**
 * Class Field
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
class Field
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var float
     */
    protected $weight;

    /**
     * @param string $name
     * @param string $text
     * @param float  $weight
     */
    public function __construct($name, $text, $weight)
    {
        $this->name = $name;
        $this->text = $text;
        $this->weight = $weight;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
}
