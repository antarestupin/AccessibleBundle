<?php

namespace Antares\Bundle\AccessibleBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Antares\Bundle\AccessibleBundle\DependencyInjection\Compiler\ConfigurationPass;

class AntaresAccessibleBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ConfigurationPass());
    }
}
