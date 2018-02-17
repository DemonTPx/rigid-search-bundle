<?php

namespace Demontpx\RigidSearchBundle\Pagination;

use Demontpx\RigidSearchBundle\Model\SearchQuery;
use Demontpx\RigidSearchBundle\Search\SearchManager;
use Knp\Component\Pager\Event\ItemsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @copyright 2015 Bert Hekman
 */
class SearchQueryPaginationSubscriber implements EventSubscriberInterface
{
    /** @var SearchManager */
    private $searchManager;

    public function __construct(SearchManager $searchManager)
    {
        $this->searchManager = $searchManager;
    }

    public function items(ItemsEvent $event)
    {
        $query = $event->target;

        if ( ! $query instanceof SearchQuery) {
            return;
        }

        $queryString = (string) $query;

        $event->count = $this->searchManager->count($queryString);
        $event->items = $this->searchManager->search($queryString, $event->getOffset(), $event->getLimit());
        $event->stopPropagation();
    }

    public static function getSubscribedEvents()
    {
        return [
            'knp_pager.items' => ['items', 1],
        ];
    }
}
