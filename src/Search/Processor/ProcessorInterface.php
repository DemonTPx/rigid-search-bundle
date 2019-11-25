<?php declare(strict_types=1);

namespace Demontpx\RigidSearchBundle\Search\Processor;

use Demontpx\RigidSearchBundle\Model\Document;

/**
 * @copyright 2015 Bert Hekman
 */
interface ProcessorInterface
{
    public function process(Document $document, string $type): void;
}
