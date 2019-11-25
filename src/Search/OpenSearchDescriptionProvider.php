<?php declare(strict_types=1);

namespace Demontpx\RigidSearchBundle\Search;

use Demontpx\RigidSearchBundle\Model\OpenSearchConfiguration;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

/**
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

    public function get(): string
    {
        $request = $this->requestStack->getMasterRequest();

        $url = $request->getSchemeAndHttpHost() . $this->router->generate('demontpx_rigid_search_result') . '?query={searchTerms}';

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

    private function value(string $value): string
    {
        return htmlspecialchars($value, ENT_COMPAT | ENT_HTML5, 'UTF-8');
    }
}
