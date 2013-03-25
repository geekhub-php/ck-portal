<?php

namespace Geekhub\FileBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('geekhub_file');

        $rootNode
            ->children()
                ->arrayNode('image')
                    ->children()
                        ->arrayNode('allowed_extensions')
                            ->prototype('scalar')->end()
                            ->info('Array of allowed extensions files that can be approve at uploading at the server')
                            ->example('[ jpg, png ]')
                        ->end()
                        ->scalarNode('size_limit')
                            ->defaultValue('10485760')
                            ->info('Max size for uploading files in bytes. By default 10485760 its 10Mb')
                            ->example('102400')
                        ->end()
                        ->scalarNode('upload_directory')
                            ->defaultValue('uploads/')
                            ->info('The upload directory at web/ directory')
                            ->example('uploads/images/')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('document')
                    ->children()
                        ->arrayNode('allowed_extensions')
                            ->prototype('scalar')->end()
                            ->info('Array of allowed extensions files that can be approve at uploading at the server')
                            ->example('[ doc, xls, xlsx ]')
                        ->end()
                        ->scalarNode('size_limit')
                            ->defaultValue('10485760')
                            ->info('Max size for uploading files in bytes. By default 10485760 its 10Mb')
                            ->example('102400')
                        ->end()
                        ->scalarNode('upload_directory')
                            ->defaultValue('uploads/')
                            ->info('The upload directory at web/ directory')
                            ->example('uploads/images/')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('video')
                    ->children()
                        ->arrayNode('allowed_providers')
                            ->prototype('scalar')->end()
                            ->info('Allowed domen for insert link')
                            ->example('{ youtube.com, vimeo.com }')
                        ->end()
                        ->scalarNode('upload_directory')
                            ->defaultValue('uploads/video-thumbnails/')
                            ->info('The upload directory at web/ directory')
                            ->example('uploads/video-thumbnails/')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
