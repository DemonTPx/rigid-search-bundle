<?php

namespace Demontpx\RigidSearchBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('demontpx_rigid_search');

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
