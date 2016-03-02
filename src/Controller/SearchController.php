<?php

namespace Demontpx\RigidSearchBundle\Controller;

use Demontpx\RigidSearchBundle\Form\QueryType;
use Demontpx\RigidSearchBundle\Model\SearchQuery;
use Demontpx\UtilBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SearchController
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
class SearchController extends BaseController
{
    /**
     * @param Request $request
     *
     * @return array
     *
     * @Template
     */
    public function searchFormAction(Request $request)
    {
        $form = $this->createForm(QueryType::class, $request->query->get('query', ''), [
            'action' => $this->generateUrl('demontpx_rigid_search_result'),
        ]);

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @param Request $request
     *
     * @return array
     *
     * @Route(name="demontpx_rigid_search_result", path="/")
     * @Template
     */
    public function searchResultAction(Request $request)
    {
        $query = $request->query->get('query', '');

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            new SearchQuery($query),
            $request->get('page', 1),
            10
        );

        return [
            'pagination' => $pagination,
        ];
    }

    /**
     * @return Response
     *
     * @Route(path="/open-search.osd")
     */
    public function openSearchAction()
    {
        $provider = $this->get('demontpx_rigid_search.open_search_description_provider');

        return new Response($provider->get(), Response::HTTP_OK, [
            'Content-Type' => 'application/opensearchdescription+xml',
        ]);
    }
}
