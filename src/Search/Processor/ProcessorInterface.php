<?php

namespace Demontpx\RigidSearchBundle\Search\Processor;

use Demontpx\RigidSearchBundle\Model\Document;

/**
 * Interface ProcessorInterface
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
interface ProcessorInterface
{
    public function process(Document $document, string $type): void;
}
