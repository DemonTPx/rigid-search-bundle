<?php

namespace DependencyInjection;

use Demontpx\RigidSearchBundle\DependencyInjection\DemontpxRigidSearchExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class DemontpxRigidSearchExtensionTest
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
class DemontpxRigidSearchExtensionTest extends \PHPUnit_Framework_TestCase 
{
    public function testCorrectRoot()
    {
        $configs = [[
            'open_search' => [
                'short_name' => 'Short name',
                'description' => 'Description',
                'tags' => 'Tags',
                'contact' => 'Contact',
            ],
        ]];

        $extension = new DemontpxRigidSearchExtension();
        $extension->load($configs, $container = new ContainerBuilder());

        $root = 'demontpx_rigid_search.';

        foreach (array_keys($container->getDefinitions()) as $id) {
            $this->assertStringStartsWith($root, $id);
        }
        foreach (array_keys($container->getAliases()) as $id) {
            $this->assertStringStartsWith($root, $id);
        }
        foreach (array_keys($container->getParameterBag()->all()) as $id) {
            $this->assertStringStartsWith($root, $id);
        }
    }
}
