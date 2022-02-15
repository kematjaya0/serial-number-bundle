<?php

namespace Kematjaya\SerialNumberBundle\EventListener;

use Kematjaya\SerialNumber\Builder\SerialNumberBuilderInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Description of SerialNumberEventListener
 *
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SerialNumberEventListener 
{
    /**
     * 
     * @var SerialNumberBuilderInterface
     */
    private $serialNumberBuilder;
    
    /**
     * 
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;
    
    function __construct(SerialNumberBuilderInterface $serialNumberBuilder, UrlGeneratorInterface $urlGenerator) 
    {
        $this->serialNumberBuilder = $serialNumberBuilder;
        $this->urlGenerator = $urlGenerator;
    }
    
    public function onKernelRequest(RequestEvent $event)
    {
        $path           = $event->getRequest()->getPathInfo();
        $redirectUrl    = $this->urlGenerator->generate('kmj_invalid_serial_number');
        
        if ($path === $redirectUrl) {
            
            return;
        }
        
        $serialNumber   = $this->serialNumberBuilder->getSerialNumber();
        if (null !== $serialNumber) {
            
            return;
        }
        
        $response = new RedirectResponse($redirectUrl);
        $event->setResponse($response);
    }
}
