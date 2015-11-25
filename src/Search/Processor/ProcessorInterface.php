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
    /**
     * @param Document $document
     * @param string   $type
     */
    public function process(Document $document, $type);
}
