<?php

namespace PrettyAdmin\PrettyAdminBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('pretty_admin');

        $rootNode
            ->children()
                ->arrayNode('entities')
                    ->children()
                        ->scalarNode('bundle')
                            //->defaultValue()
                            ->info('name of bundle where you have your entities')
                            ->example('for example, PrettyAdminBundle')
                        ->end()
                        ->arrayNode('list')
                            ->prototype('scalar')
                            ->end()
                            ->info('array of entities to apply PrettyAdminBundle')
                        ->end()
                    ->end()
                ->end()
            ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
