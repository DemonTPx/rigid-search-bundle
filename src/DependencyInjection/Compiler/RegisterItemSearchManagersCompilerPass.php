<?php declare(strict_types=1);

namespace Demontpx\RigidSearchBundle\DependencyInjection\Compiler;

use Demontpx\RigidSearchBundle\Search\ItemSearchManagerFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @copyright 2015 Bert Hekman
 */
class RegisterItemSearchManagersCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $factory = $container->getDefinition(ItemSearchManagerFactory::class);

        $list = $container->findTaggedServiceIds('demontpx_rigid_search.item_search_manager');
        foreach (array_keys($list) as $id) {
            $factory->addMethodCall('add', [new Reference($id)]);
        }
    }
}
