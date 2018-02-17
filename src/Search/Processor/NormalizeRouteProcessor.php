<?php

namespace Demontpx\RigidSearchBundle\Search\Processor;

use Demontpx\RigidSearchBundle\Model\Document;
use Symfony\Component\Routing\RequestContext;

/**
 * @copyright 2015 Bert Hekman
 */
class NormalizeRouteProcessor implements ProcessorInterface
{
    /** @var RequestContext */
    private $requestContext;

    public function __construct(RequestContext $requestContext)
    {
        $this->requestContext = $requestContext;
    }

    public function process(Document $document, string $type): void
    {
        $url = $document->getUrl();
        $baseUrl = $this->requestContext->getBaseUrl();

        if (empty($baseUrl) || strpos($url, $baseUrl) !== 0) {
            return;
        }

        $url = substr($url, strlen($baseUrl));
        $document->setUrl($url);
    }
}
