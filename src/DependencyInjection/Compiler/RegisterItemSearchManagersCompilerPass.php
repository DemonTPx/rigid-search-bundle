<?php

namespace Demontpx\RigidSearchBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RegisterItemSearchManagersCompilerPass
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
class RegisterItemSearchManagersCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $factory = $container->getDefinition('demontpx_rigid_search.item_search_manager_factory');

        $list = $container->findTaggedServiceIds('demontpx_rigid_search.item_search_manager');
        foreach (array_keys($list) as $id) {
            $factory->addMethodCall('add', [new Reference($id)]);
        }
    }
}
