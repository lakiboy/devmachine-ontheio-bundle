<?php

namespace Devmachine\Bundle\OntheioBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();

        $root = $builder->root('devmachine_ontheio');
        $root
            ->children()
                ->arrayNode('image')
                    ->children()
                        ->scalarNode('key')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('secret')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('base_url')->cannotBeEmpty()->defaultValue('https://i.onthe.io')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $builder;
    }
}
