<?php

namespace Demontpx\RigidSearchBundle\Search;

use Demontpx\RigidSearchBundle\Model\OpenSearchConfiguration;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class OpenSearchDescriptionProvider
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
class OpenSearchDescriptionProvider
{
    /** @var RequestStack */
    private $requestStack;

    /** @var RouterInterface */
    private $router;

    /** @var OpenSearchConfiguration */
    private $configuration;

    /**
     * @param RequestStack            $requestStack
     * @param RouterInterface         $router
     * @param OpenSearchConfiguration $configuration
     */
    public function __construct(
        RequestStack $requestStack,
        RouterInterface $router,
        OpenSearchConfiguration $configuration
    )
    {
        $this->requestStack = $requestStack;
        $this->router = $router;
        $this->configuration = $configuration;
    }

    /**
     * @return string
     */
    public function get()
    {
        $request = $this->requestStack->getMasterRequest();

        $url = $request->getSchemeAndHttpHost() . $this->router->generate('demontpx_search_result') . '?query={searchTerms}';

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><OpenSearchDescription  xmlns="http://a9.com/-/spec/opensearch/1.1/"/>');

        $xml->addChild('ShortName', $this->value($this->configuration->getShortName()));
        $xml->addChild('Description', $this->value($this->configuration->getDescription()));
        $xml->addChild('Tags', $this->value($this->configuration->getTags()));
        $xml->addChild('Contact', $this->value($this->configuration->getContact()));
        $urlElement = $xml->addChild('Url');
        $urlElement->addAttribute('type', 'text/html');
        $urlElement->addAttribute('template', $this->value($url));

        $xml->addChild('OutputEncoding', 'UTF-8');
        $xml->addChild('InputEncoding', 'UTF-8');

        return $xml->asXML();
    }

    /**
     * @param string $value
     *
     * @return string
     */
    private function value($value)
    {
        return htmlspecialchars($value, null, 'UTF-8');
    }
}
