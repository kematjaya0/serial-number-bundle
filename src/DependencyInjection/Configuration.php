<?php

namespace Kematjaya\SerialNumberBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class Configuration implements ConfigurationInterface 
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = (new TreeBuilder('kmj_serial_number'));
                //->getRootNode()
                //->children()
                //->end();
        
        return $treeBuilder;
    }
}
