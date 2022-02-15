<?php

namespace Kematjaya\SerialNumberBundle\EventListener;

use Kematjaya\SerialNumber\Builder\SerialNumberBuilderInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

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
    
    /**
     * 
     * @var array
     */
    private $configs;
    
    function __construct(ParameterBagInterface $parameterBag, SerialNumberBuilderInterface $serialNumberBuilder, UrlGeneratorInterface $urlGenerator) 
    {
        $this->serialNumberBuilder = $serialNumberBuilder;
        $this->urlGenerator = $urlGenerator;
        $this->configs = $parameterBag->get('kmj_serial_number');
    }
    
    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        }
        
        if (true !== $this->configs["is_activated"]) {
            return;
        }
        
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
