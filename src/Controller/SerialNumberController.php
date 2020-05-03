<?php

namespace Kematjaya\SerialNumberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Kematjaya\SerialNumberBundle\Builder\SerialNumberBuilder;
use kematjaya\SerialNumberBundle\Repository\ParameterRepoInterface;
use Kematjaya\SerialNumberBundle\Entity\ParameterInterface;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SerialNumberController extends AbstractController
{
    protected $serialNumberBuilder;
    
    protected $requestStack;
    
    protected $parameterRepo;
    
    public function __construct(
        RequestStack $requestStack, 
        SerialNumberBuilder $serialNumberBuilder,
        ParameterRepoInterface $parameterRepo) 
    {
        $this->requestStack = $requestStack;
        $this->serialNumberBuilder = $serialNumberBuilder;
        $this->parameterRepo = $parameterRepo;
    }
    
    public function invalidSerialNumber()
    {
        $request = $this->requestStack->getCurrentRequest();
        if($request->getMethod() == Request::METHOD_POST) 
        {
            if ($this->serialNumberBuilder->validateSerialNumber($request->request->get('key')) 
                and $this->isCsrfTokenValid('serial_number', $request->request->get('_csrf_token'))) 
            {
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
        }
        return $this->render('@SerialNumber/security/invalid-serial-number.html.twig');
    }
    
}
