<?php

namespace DependencyInjection;

use Demontpx\RigidSearchBundle\DependencyInjection\DemontpxRigidSearchExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @copyright 2015 Bert Hekman
 */
class DemontpxRigidSearchExtensionTest extends TestCase
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

        $root = 'Demontpx\\RigidSearchBundle\\';

        foreach (array_keys($container->getDefinitions()) as $id) {
            if ($id == 'service_container') {
                continue;
            }
            $this->assertStringStartsWith($root, $id);
        }
    }
}
