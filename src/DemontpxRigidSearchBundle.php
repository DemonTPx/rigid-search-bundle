<?php declare(strict_types=1);

namespace Demontpx\RigidSearchBundle;

use Demontpx\RigidSearchBundle\DependencyInjection\Compiler\RegisterItemSearchManagersCompilerPass;
use Demontpx\RigidSearchBundle\DependencyInjection\Compiler\RegisterSearchDocumentProcessorsCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @copyright 2015 Bert Hekman
 */
class DemontpxRigidSearchBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegisterItemSearchManagersCompilerPass());
        $container->addCompilerPass(new RegisterSearchDocumentProcessorsCompilerPass());
    }
}
