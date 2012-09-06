<?php

namespace Propel\TranslationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PropelTranslationExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        // sets parameters
        $container->setParameter('propel.translation.managed_locales', $config['managed_locales']);
        $container->setParameter('propel.translation.base_layout', $config['base_layout']);
        $container->setParameter('propel.translation.grid_template', $config['grid_template']);
        $container->setParameter('propel.translation.new_template', $config['new_template']);
        $container->setParameter('propel.translation.grid_input_type', $config['grid_input_type']);
        $container->setParameter('propel.translation.path_cache_app', $config['path_cache_app']);
        $container->setParameter('propel.translation.path_export_dir', $config['path_export_dir']);

        // @note use it for multi-orm
        //$container->setParameter('propel.translation.storage', $config['storage']);
    }
}
