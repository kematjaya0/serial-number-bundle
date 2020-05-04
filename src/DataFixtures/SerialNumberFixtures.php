<?php

namespace Kematjaya\SerialNumberBundle\DataFixtures;

use Kematjaya\SerialNumberBundle\Builder\SerialNumberBuilder;
use Kematjaya\SerialNumberBundle\Repository\ParameterRepoInterface;
use Kematjaya\SerialNumberBundle\Entity\ParameterInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SerialNumberFixtures extends Fixture implements FixtureGroupInterface
{
    private $serialNumberBuilder;
    
    private $parameterRepo;
    
    public function __construct(SerialNumberBuilder $serialNumberBuilder, ParameterRepoInterface $parameterRepo) 
    {
        $this->serialNumberBuilder = $serialNumberBuilder;
        $this->parameterRepo = $parameterRepo;
    }
    
    public function load(ObjectManager $manager) 
    {
        $parameter      = $this->parameterRepo->findOneByCode(ParameterInterface::CODE_SECURITY);
        $serialNumber   = $this->serialNumberBuilder->generateSerialNumber();
        $data           = [ParameterInterface::COLUMN_SECURITY_NUMBER => $serialNumber->getNumber()];
        $parameter->setValue($data);
        $manager->persist($parameter);
        $manager->flush();
    }

    public static function getGroups(): array 
    {
        return ['kmj-serial-number'];
    }

}
