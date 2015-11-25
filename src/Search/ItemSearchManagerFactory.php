<?php

namespace Demontpx\RigidSearchBundle\Search;

/**
 * Class ItemSearchManagerFactory
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
class ItemSearchManagerFactory
{
    /** @var ItemSearchManagerInterface[] */
    private $list = [];

    /** @var ItemSearchManagerInterface[] */
    private $classMap = [];

    /**
     * @param ItemSearchManagerInterface $manager
     */
    public function add(ItemSearchManagerInterface $manager)
    {
        $this->list[$manager->getType()] = $manager;
        $this->classMap[$manager->getClass()] = $manager->getType();
    }

    /**
     * @param string $class
     *
     * @return ItemSearchManagerInterface
     */
    public function getByClass($class)
    {
        if ( ! isset($this->classMap[$class])) {
            throw new \RuntimeException(sprintf(
                'No search configuration registered for class %s',
                $class
            ));
        }

        return $this->getByType($this->classMap[$class]);
    }

    /**
     * @param string $type
     *
     * @return ItemSearchManagerInterface
     */
    public function getByType($type)
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
    public function getAll()
    {
        return $this->list;
    }
}
