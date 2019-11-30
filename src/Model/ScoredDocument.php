<?php declare(strict_types=1);

namespace Demontpx\RigidSearchBundle\Model;

/**
 * @copyright 2015 Bert Hekman
 */
class ScoredDocument
{
    private Document $document;
    private float $score;

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
