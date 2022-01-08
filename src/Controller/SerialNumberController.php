<?php

namespace Kematjaya\SerialNumberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Kematjaya\SerialNumber\Builder\SerialNumberBuilderInterface;
use Kematjaya\SerialNumberBundle\Repository\ParameterRepoInterface;
use Kematjaya\SerialNumberBundle\Entity\ParameterInterface;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SerialNumberController extends AbstractController
{
    
    /**
     * 
     * @var SerialNumberBuilderInterface
     */
    protected $serialNumberBuilder;
    
    /**
     * 
     * @var RequestStack
     */
    protected $requestStack;
    
    /**
     * 
     * @var ParameterRepoInterface
     */
    protected $parameterRepo;
    
    public function __construct(RequestStack $requestStack, SerialNumberBuilderInterface $serialNumberBuilder, ParameterRepoInterface $parameterRepo) 
    {
        $this->requestStack = $requestStack;
        $this->serialNumberBuilder = $serialNumberBuilder;
        $this->parameterRepo = $parameterRepo;
    }
    
    public function invalidSerialNumber()
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($request->getMethod() !== Request::METHOD_POST) {
            
            return $this->render('@SerialNumber/security/invalid-serial-number.html.twig');
        }
        
        if (!$this->isCsrfTokenValid('serial_number', $request->request->get('_csrf_token'))) {
            $this->addFlash('error', 'crsf token detected.');
            
            return $this->render('@SerialNumber/security/invalid-serial-number.html.twig');
        }
        
        if ($this->serialNumberBuilder->validateSerialNumber($request->request->get('key'))) {
            $em = $this->getDoctrine()->getManager();
            $con = $em->getConnection();
            $con->beginTransaction();
            try{
                $mParameter = $this->parameterRepo->findOneByCode(ParameterInterface::CODE_SECURITY);
                $values = $mParameter->getValue();
                $values[ParameterInterface::COLUMN_SECURITY_NUMBER] = $request->request->get('key');
                $mParameter->setValue($values);
                $em->persist($mParameter);
                $em->flush();
                $con->commit();
                
                return $this->redirectToRoute('homepage');
            } catch (\Exception $ex) 
            {
                $con->rollBack();
                $this->addFlash("error", "error : ". $ex->getMessages());
            }
        }
            
        return $this->render('@SerialNumber/security/invalid-serial-number.html.twig');
    }
    
    
}
