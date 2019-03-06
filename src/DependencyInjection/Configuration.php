<?php

namespace Demontpx\RigidSearchBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @copyright 2015 Bert Hekman
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('demontpx_rigid_search');

        // For BC with symfony/config < 4.2
        if (method_exists($treeBuilder, 'getRootNode')) {
            /** @var ArrayNodeDefinition $rootNode */
            $rootNode = $treeBuilder->getRootNode();
        } else {
            $rootNode = $treeBuilder->root('demontpx_rigid_search');
        }

        $rootNode
            ->children()
                ->arrayNode('open_search')
                    ->isRequired()
                    ->children()
                        ->scalarNode('short_name')->isRequired()->end()
                        ->scalarNode('description')->isRequired()->end()
                        ->scalarNode('tags')->isRequired()->end()
                        ->scalarNode('contact')->isRequired()->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
