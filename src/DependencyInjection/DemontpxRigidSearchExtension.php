<?php

namespace Demontpx\RigidSearchBundle\DependencyInjection;

use Demontpx\RigidSearchBundle\Model\OpenSearchConfiguration;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class DemontpxRigidSearchExtension
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
class DemontpxRigidSearchExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $root = 'demontpx_rigid_search.';

        $openSearchConfiguration = new Definition(OpenSearchConfiguration::class, [
            $config['open_search']['short_name'],
            $config['open_search']['description'],
            $config['open_search']['tags'],
            $config['open_search']['contact']
        ]);

        $container->setDefinition($root . 'open_search.configuration', $openSearchConfiguration);
    }
}
