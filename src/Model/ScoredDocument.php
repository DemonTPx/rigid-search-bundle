<?php

namespace Demontpx\RigidSearchBundle\Model;

/**
 * Class ScoredDocument
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
class ScoredDocument
{
    /** @var Document */
    private $document;

    /** @var float */
    private $score;

    public function __construct(Document $document, float $score)
    {
        $this->document = $document;
        $this->score = $score;
    }

    public function getDocument(): Document
    {
        return $this->document;
    }

    public function getScore(): float
    {
        return $this->score;
    }
}
