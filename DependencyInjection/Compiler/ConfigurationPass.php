<?php

namespace Antares\Bundle\AccessibleBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Accessible\Configuration;
use Doctrine\Common\Cache\ChainCache;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\AnnotationReader;
use Antares\Bundle\AccessibleBundle\Service\NullService;

class ConfigurationPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $enableCache = $container->getParameter('antares_accessible.cache.enable');

        // Annotation reader
        $annotationsReader = $container->get('antares_accessible.annotations.reader');
        if ($annotationsReader instanceof NullService) {
            if ($enableCache) {
                $debug = $container->getParameter('kernel.debug');
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
        } else {
            Configuration::setAnnotationReader($annotationsReader);
        }

        // Constraints validator
        $constraintsValidator = $container->get('antares_accessible.constraints_validation.validator');
        if (!$constraintsValidator instanceof NullService) {
            Configuration::setConstraintsValidator($constraintsValidator);
        }

        // Cache driver
        if ($enableCache) {
            $cacheDriver = $container->get('antares_accessible.cache.driver');
            Configuration::setCacheDriver($cacheDriver);
        }

        // Enable the constraints validation of Initialize annotations values
        $constraintsValidationEnabled = $container->getParameter('antares_accessible.constraints_validation.enable');
        Configuration::setConstraintsValidationEnabled($constraintsValidationEnabled);

        // Enable the constraints validation of Initialize annotations values
        $validateInitializeValues = $container->getParameter('antares_accessible.constraints_validation.validate_initialize_values');
        Configuration::setInitializeValuesValidationEnabled($validateInitializeValues);
    }
}
