<?php

namespace Demontpx\RigidSearchBundle\Controller;

use Demontpx\RigidSearchBundle\Form\QueryType;
use Demontpx\RigidSearchBundle\Model\SearchQuery;
use Demontpx\RigidSearchBundle\Search\OpenSearchDescriptionProvider;
use Demontpx\UtilBundle\Controller\BaseController;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @copyright 2015 Bert Hekman
 */
class SearchController extends BaseController
{
    /** @var PaginatorInterface */
    private $paginator;
    /** @var OpenSearchDescriptionProvider */
    private $openSearchDescriptionProvider;

    public function __construct(PaginatorInterface $paginator, OpenSearchDescriptionProvider $openSearchDescriptionProvider)
    {
        $this->paginator = $paginator;
        $this->openSearchDescriptionProvider = $openSearchDescriptionProvider;
    }

    /**
     * @Template("@DemontpxRigidSearch/search/search_form.html.twig")
     */
    public function searchFormAction(Request $request): array
    {
        $form = $this->createForm(QueryType::class, $request->query->get('query', ''), [
            'action' => $this->generateUrl('demontpx_rigid_search_result'),
        ]);

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route(name="demontpx_rigid_search_result", path="/")
     * @Template("@DemontpxRigidSearch/search/search_result.html.twig")
     */
    public function searchResultAction(Request $request): array
    {
        $query = $request->query->get('query', '');

        $pagination = $this->paginator->paginate(
            new SearchQuery($query),
            $request->get('page', 1),
            10
        );

        return [
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route(path="/open-search.osd")
     */
    public function openSearchAction(): Response
    {
        return new Response($this->openSearchDescriptionProvider->get(), Response::HTTP_OK, [
            'Content-Type' => 'application/opensearchdescription+xml',
        ]);
    }
}
