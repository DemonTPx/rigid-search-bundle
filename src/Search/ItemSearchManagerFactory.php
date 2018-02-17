<?php

namespace Demontpx\RigidSearchBundle\Search;

/**
 * @copyright 2015 Bert Hekman
 */
class ItemSearchManagerFactory
{
    /** @var ItemSearchManagerInterface[] */
    private $list = [];

    /** @var ItemSearchManagerInterface[] */
    private $classMap = [];

    public function add(ItemSearchManagerInterface $manager)
    {
        $this->list[$manager->getType()] = $manager;
        $this->classMap[$manager->getClass()] = $manager->getType();
    }

    public function getByClass(string $class): ItemSearchManagerInterface
    {
        if ( ! isset($this->classMap[$class])) {
            throw new \RuntimeException(sprintf(
                'No search configuration registered for class %s',
                $class
            ));
        }

        return $this->getByType($this->classMap[$class]);
    }

    public function getByType(string $type): ItemSearchManagerInterface
    {
        if ( ! isset($this->list[$type])) {
            throw new \RuntimeException(sprintf(
                'No search configuration registered for type %s. Valid types: [%s]',
                $type,
                implode(', ', array_keys($this->list))
            ));
        }

        return $this->list[$type];
    }

    /**
     * @return ItemSearchManagerInterface[]
     */
    public function getAll(): array
    {
        return $this->list;
    }
}
