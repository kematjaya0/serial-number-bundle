<?php

namespace Kematjaya\SerialNumberBundle\Entity;

use Kematjaya\SerialNumberBundle\Entity\SettingInterface;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class Setting implements SettingInterface
{
    
    public function getSerialNumber(): ?string 
    {
        throw new \Exception(
            sprintf("please implement %s class", SettingInterface::class)
        );
    }

}
