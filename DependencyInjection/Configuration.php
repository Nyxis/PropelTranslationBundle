<?php

namespace Propel\TranslationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
* This is the class that validates and merges configuration from your app/config files
*
* To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
*
*/
class Configuration implements ConfigurationInterface
{
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Config\Definition.ConfigurationInterface::getConfigTreeBuilder()
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('propel_translation');

        // @note : options to use to manage multi-orm
        // $storages = array('orm', 'mongodb');

        $inputTypes = array('text', 'textarea');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()

                ->scalarNode('base_layout')
                    ->cannotBeEmpty()
                    ->defaultValue('PropelTranslationBundle::layout.html.twig')
                ->end()

                ->arrayNode('managed_locales')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->prototype('scalar')->end()
                ->end()

                ->scalarNode('grid_input_type')
                    ->cannotBeEmpty()
                    ->defaultValue('text')
                    ->validate()
                        ->ifNotInArray($inputTypes)
                        ->thenInvalid('The input type "%s" is not supported. Please use one of the following types: '.implode(', ', $inputTypes))
                    ->end()
                ->end()

                ->arrayNode('path_cache_app')
                    ->cannotBeEmpty()
                    ->defaultValue(array('%kernel.root_dir%'))
                    ->prototype('scalar')->end()
                ->end()

                ->scalarNode('path_export_dir')
                    ->cannotBeEmpty()
                    ->defaultValue('%kernel.root_dir%/Resources/translations')
                ->end()

                // @see notes
                // ->scalarNode('storage')
                //     ->cannotBeEmpty()
                //     ->defaultValue('orm')
                //     ->validate()
                //         ->ifNotInArray($storages)
                //         ->thenInvalid('The storage "%s" is not supported. Please use one of the following storage: '.implode(', ', $storages))
                //     ->end()
                // ->end()

            ->end()
        ;

        return $treeBuilder;
    }
}