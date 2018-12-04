<?php

namespace Demontpx\RigidSearchBundle\DependencyInjection\Compiler;

use Demontpx\RigidSearchBundle\Search\SearchManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @copyright 2015 Bert Hekman
 */
class RegisterSearchDocumentProcessorsCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $manager = $container->getDefinition(SearchManager::class);

        $list = $container->findTaggedServiceIds('demontpx_rigid_search.document_processor');
        foreach (array_keys($list) as $id) {
            $manager->addMethodCall('registerProcessor', [new Reference($id)]);
        }
    }
}
