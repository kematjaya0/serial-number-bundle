<?php
namespace Kematjaya\SerialNumberBundle\Builder;

use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Kematjaya\SerialNumber\Builder\SerialNumberBuilder as Base;
use Kematjaya\SerialNumberBundle\Entity\SettingInterface;
use Kematjaya\SerialNumber\Lib\SerialNumberInterface;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SerialNumberBuilder extends Base
{
    /**
     * 
     * @var SettingInterface
     */
    private $setting;
    
    /**
     * 
     * @var SessionInterface
     */
    private $session;
    
    function __construct(PasswordHasherInterface $encoder, SerialNumberInterface $serialNumber, SettingInterface $setting, SessionInterface $session) 
    {
        $this->encoder = $encoder;
        $this->setting = $setting;
        $this->session = $session;
        parent::__construct($encoder, $serialNumber);
    }
    
    /**
     * 
     * @return SerialNumber
     */
    public function getSerialNumber(): ?string
    {
        $serialNumber = $this->setting->getSerialNumber();
        if (!$serialNumber) {
            return null;
        }
        
        return $this->validateSerialNumber($serialNumber);
    }
    
    /**
     * 
     * @param type $number
     * @return bool
     */
    public function validateSerialNumber($number):?string
    {
        if (!$this->session->has('kmjsn') || !$this->session->get('kmjsn')) {
            $number = parent::validateSerialNumber($number);
            if ($number) {
                $this->session->set('kmjsn', $number);
            }
        }
        
        return $this->session->get('kmjsn');
    }
}
