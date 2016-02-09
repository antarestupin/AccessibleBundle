<?php

namespace Antares\Bundle\AccessibleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    private $debug;

    public function __construct($debug)
    {
        $this->debug = (bool) $debug;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('antares_accessible');

        $rootNode
            ->children()
                ->arrayNode('cache')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enable')->defaultFalse()->end()
                    ->end()
                ->end()
                ->arrayNode('constraints_validation')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('validate_initialize_values')->defaultValue($this->debug)->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
