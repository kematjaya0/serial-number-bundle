<?php

namespace Kematjaya\SerialNumberBundle\Tests;

use Kematjaya\SerialNumber\Lib\SerialNumberInterface;
use Kematjaya\SerialNumberBundle\Tests\AppKernel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class BundleTest extends WebTestCase 
{
    public function testInitBundle()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        
        $this->assertTrue($container->has('kmj.serial_number'));
        $this->assertTrue($container->has('kmj.native_password_encoder.generic'));
        $this->assertTrue($container->has('kmj.serial_number_builder'));
        if($container->has('kmj.serial_number_builder'))
        {
            $sn = $container->get('kmj.serial_number_builder')->generateSerialNumber();
            $this->assertInstanceOf(SerialNumberInterface::class, $sn);
        }
        
        dump($container->has('kmj.serial_number_console'));exit;
    }
    
    public static function getKernelClass() 
    {
        return AppKernel::class;
    }
}
