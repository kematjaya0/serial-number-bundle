<?php

namespace Kematjaya\SerialNumberBundle\DependencyInjection;

use Kematjaya\SerialNumberBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SerialNumberExtension extends Extension 
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container,
            new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        
        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('kmj_serial_number', $config);
    }
}
