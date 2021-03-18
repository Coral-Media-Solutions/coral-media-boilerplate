<?php


namespace CoralMedia\Component\Api\Security\DataProvider;


use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Metadata\Resource\Factory\ResourceNameCollectionFactoryInterface;
use CoralMedia\Component\Api\Security\Model\Resource;

final class ResourceCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{

    /**
     * @var array
     */
    protected $resourceNameCollection;

    public function __construct(ResourceNameCollectionFactoryInterface $resourceNameCollection)
    {
        $this->resourceNameCollection = (array) $resourceNameCollection->create()->getIterator();
    }

    public function getCollection(string $resourceClass, string $operationName = null)
    {
        foreach ($this->resourceNameCollection as $resourceName) {
            $resource = new Resource();
            $resource->setClassName($resourceName);
            yield $resource;
        }
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === Resource::class;
    }
}