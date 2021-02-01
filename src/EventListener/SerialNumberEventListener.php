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
    
    private $serialNumberBuilder;
    
    private $urlGenerator;
    
    function __construct(SerialNumberBuilderInterface $serialNumberBuilder, UrlGeneratorInterface $urlGenerator) 
    {
        $this->serialNumberBuilder = $serialNumberBuilder;
        $this->urlGenerator = $urlGenerator;
    }
    
    public function onKernelRequest(RequestEvent $event)
    {
        $path           = $event->getRequest()->attributes->get('_route');
        $redirectUrl    = 'kmj_invalid_serial_number';
        $serialNumber   = $this->serialNumberBuilder->getSerialNumber();
        
        $url = null;
        if($path !== $redirectUrl) {
            if(!$serialNumber) {
                $url = $this->urlGenerator->generate($redirectUrl);
            }
            
            if($url) {
                $response = new RedirectResponse($url);
                $event->setResponse($response);
            }
        }
        
    }
}
