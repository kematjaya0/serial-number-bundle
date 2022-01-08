<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace Kematjaya\SerialNumberBundle\Repository;

use Kematjaya\SerialNumberBundle\Entity\ParameterInterface;

/**
 * Description of MParameterRepository
 *
 * @author guest
 */
class MParameterRepository implements ParameterRepoInterface 
{
    //put your code here
    public function findOneByCode($code): ParameterInterface 
    {
        throw new \Exception("please implement interface : " . ParameterRepoInterface::class);
    }

}
