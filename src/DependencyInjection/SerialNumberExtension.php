<?php

namespace Kematjaya\SerialNumberBundle\DependencyInjection;

use Kematjaya\SerialNumberBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SerialNumberExtension extends Extension 
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container, 
            new FileLocator(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Resources/config')
        );
        $loader->load('services.yaml');
        
        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('kmj_serial_number', $config);
    }
}
