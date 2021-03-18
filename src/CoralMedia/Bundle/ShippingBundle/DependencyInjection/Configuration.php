<?php


namespace CoralMedia\Bundle\ShippingBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('coral_media_shipping');
        $rootNode = $treeBuilder->getRootNode();

        $this->_addUPSSection($rootNode);

        return $treeBuilder;
    }

    private function _addUPSSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('UPS')
                    ->children()
                        ->arrayNode('credentials')
                            ->children()
                                ->scalarNode('api_key')
                                    ->info('UPS API key')
                                ->end()
                                ->scalarNode('username')
                                    ->info('UPS Account username')
                                ->end()
                                ->scalarNode('password')
                                    ->info('UPS Account password')
                                ->end()
                            ->end()
                        ->end()
                        ->scalarNode('testing')
                            ->info('Set true if you are in testing or development environments')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}