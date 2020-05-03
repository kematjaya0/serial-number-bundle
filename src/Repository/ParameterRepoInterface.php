<?php

namespace Kematjaya\SerialNumberBundle\Repository;

use Kematjaya\SerialNumberBundle\Entity\ParameterInterface;
use Doctrine\Common\Persistence\ObjectRepository;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface ParameterRepoInterface extends ObjectRepository 
{
    /**
     * if not exist create new object
     * @param type $code
     * @return ParameterInterface
     */
    public function findOneByCode($code):ParameterInterface;
}
