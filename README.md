# DemonTPx rigid search bundle

Provides a way to make entities searchable.

Searches will be sorted by relevance which is calculated using the weight you can configure to the fields you index.

## Installation

Require the bundle using composer:

```bash
composer require demontpx/rigid-search-bundle
```

Then add it to your bundles section in `AppKernel.php`:

```php
new Demontpx\RigidSearchBundle\DemontpxRigidSearchBundle()
```

## Usage: Making an entity searchable

Lets say we want to index a `NewsItem` entity:

```php
class NewsItem {
    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    // ...
}
```

The first step is to create a new class which implements the `SearchDocumentExtractorInterface`. In here you define in which fields there needs to be searched and how important they are in relation to each other.

```php
class NewsItemDocumentExtractor implements SearchDocumentExtractorInterface {
    public function extractDocument($item) {
        // $item should be of the type NewsItem
        
        // The title, description and URL you put in here are only used for display and link to the item
        // They are not searchable unless you add them as fields as well (see below!)
        $document = new Document($item->getTitle(), $item->getDescription(), $this->generateUrl($item));
        
        // These are the fields on which items can be found
        // The last argument are the weight values, which can be any relative number 
        $document->addField(new Field('title', $item->getTitle(), 1.0);
        $document->addField(new Field('text', $item->getText(), 0.8);
        $document->addField(new Field('category', $item->getCategoryName(), 0.2);
        $document->addField(new Field('tags', implode(' ', $item->getTagList()->toArray()), 0.25);
        
        return $document;
    }
    
    public function extractId($item) {
        return $item->getId();
    }
}
```

Step two is to create another new class which implements the `ItemSearchManagerInterface`:

```php
class NewsItemSearchManager implements ItemSearchManagerInterface {
    public function getClass() {
        // Classname of the entity
        return NewsItem::class;
    }

    public function getType() {
        // Short arbitrary unique name to describe the entity
        return 'news';
    }

    public function getDocumentExtractor() {
        // Return the class created earlier
        // You could, of course, also inject the extractor into this class using the service container and pass it here
        return new NewsItemDocumentExtractor();
    }

    public function fetchAll() {
        // This method should return all searchable items of this type (ie: only published news items)
        // This is used when reindexing all items of this type
        // You should figure out for yourself where these entities should come from
        // For example: get these from an EntityRepository
        return $this->repository->fetchAllPublished();
    }
}
```

Register this class as a service in the container:

```yml
my_bundle.news_item_search_manager:
    class: MyBundle\NewsItemSearchManager
    tags:
        - { name: demontpx_rigid_search.item_search_manager }
```

If everything is configured correctly, you should be able to index all `news` items using this command:

```bash
app/console demontpx:search:reindex:type news
```

The next step is to trigger the index and remove manually when a news item is created, updated or removed. This could be achieved using events, or you could manually index and remove items from your search index in the controller:

```php
class NewsItemController extends Controller {
    public function newAction() {
        $item = new NewsItem();
        // ... Do your persist logic here
        
        $searchManager = $this->get('demontpx_rigid_search.search_manager');
        $searchManager->index($item);
    }
    
    public function editAction(NewsItem $item) {
        // ... Do your persist logic here
        
        $searchManager = $this->get('demontpx_rigid_search.search_manager');
        $searchManager->index($item);
    }
    
    public function removeAction(NewsItem $item) {
        $oldId = $item->getId();
        
        // ... Do your remove logic here
        
        $searchManager = $this->get('demontpx_rigid_search.search_manager');
        $searchManager->remove($item);
        
        // Doctrine ORM resets the item id to null after a delete, so you might want to use this:
        $searchManager->removeByClassAndId(get_class($item), $oldId);
    }
}
```

## Usage: Adding the search field and showing results

The first step is to add this to your `routing.yml`:

```yml
demontpx_rigid_search:
    resource: "@DemontpxRigidSearchBundle/Resources/config/routing.yml"
    prefix:   /search
```

After that you could add this to any of your twig templates:

```twig
{{ render(controller('DemontpxRigidSearchBundle:Search:searchForm', {}, { query: app.request.query.get('query', '') })) }}
```

Which will add the search input field. When submitted, this will show the search result.

The search result page will extend the `::base.html.twig` template by default. Override the whole template by creating `app/Resources/DemontpxRigidSearchBundle/views/Search/searchResult.html.twig`.
