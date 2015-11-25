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

    /**
     * @param Document $document
     * @param float    $score
     */
    public function __construct(Document $document, $score)
    {
        $this->document = $document;
        $this->score = $score;
    }

    /**
     * @return Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @return float
     */
    public function getScore()
    {
        return $this->score;
    }
}
