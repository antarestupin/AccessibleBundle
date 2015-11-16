<?php

namespace Antares\AccessibleBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Accessible\Configuration;
use Doctrine\Common\Cache\ChainCache;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\AnnotationReader;

class ConfigurationPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $enableCache = $container->getParameter('antares_accessible.cache.enable');
        $debug = $container->getParameter('kernel.debug');

        if ($enableCache) {
            // Cache driver
            $cacheDriver = $container->get('antares_accessible.cache.driver');
            Configuration::setCacheDriver($cacheDriver);

            // Annotation reader cache driver
            $annotationCacheDriver = $container->get('antares_accessible.annotations.cache_driver');
            $annotationsCache = new ChainCache([
                new ArrayCache(),
                $annotationCacheDriver
            ]);

            Configuration::setAnnotationReader(
                new CachedReader(
                    new AnnotationReader(),
                    $annotationsCache,
                    $debug
                )
            );
        }

        // Enable the constraints validation of Initialize annotations values
        $validateInitializeValues = $container->getParameter('antares_accessible.constraints_validation.validate_initialize_values');
        Configuration::setInitializeValuesValidationEnabled($validateInitializeValues);
    }
}
