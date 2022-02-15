<?php

namespace Kematjaya\SerialNumberBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class Configuration implements ConfigurationInterface 
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = (new TreeBuilder('serial_number'));
        $rootNode = $treeBuilder->getRootNode();
        
        $this->addChildConfig($rootNode->children());
        
        return $treeBuilder;
    }
    
    public function addChildConfig(NodeBuilder $node)
    {
        $node
            ->booleanNode('is_activated')->defaultTrue()->end();
    }
}
