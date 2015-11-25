<?php

namespace Demontpx\RigidSearchBundle\Search\Processor;

use Demontpx\RigidSearchBundle\Model\Document;
use Symfony\Component\Routing\RequestContext;

/**
 * Class NormalizeRouteProcessor
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
class NormalizeRouteProcessor implements ProcessorInterface
{
    /** @var RequestContext */
    private $requestContext;

    /**
     * @param RequestContext $requestContext
     */
    public function __construct(RequestContext $requestContext)
    {
        $this->requestContext = $requestContext;
    }

    public function process(Document $document, $type)
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
