<?php

namespace Kematjaya\SerialNumberBundle\Controller;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Kematjaya\SerialNumberBundle\Builder\SerialNumberBuilder;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SerialNumberController extends AbstractController
{
    protected $serialNumberBuilder;
    
    protected $requestStack;
    
    public function __construct(RequestStack $requestStack, SerialNumberBuilder $serialNumberBuilder) 
    {
        $this->requestStack = $requestStack;
        $this->serialNumberBuilder = $serialNumberBuilder;
    }
    
    public function invalidSerialNumber()
    {
        $request = $this->requestStack->getCurrentRequest();
        if($request->getMethod() == Request::METHOD_POST) 
        {
            if(!$this->serialNumberBuilder->validateSerialNumber($request->request->get('key'))) 
            {
                $this->addFlash('error', 'invalid_serial_number');
                return $this->redirectToRoute('app_invalid_serial_number');
            }
            
            if ($this->isCsrfTokenValid('serial_number', $request->request->get('_csrf_token'))) 
            {
                dump($request->request->get('key'));exit;  
                /*$em = $this->getDoctrine()->getManager();
                $con = $em->getConnection();
                $con->beginTransaction();
                try{
                    $mParameter = $mParameterRepo->findOneBy(['code' => MParameter::CODE_SECURITY]);
                    if(!$mParameter) {
                        $mParameter = new MParameter();
                        $mParameter->setCode($k);
                        $names = MParameter::getCodeArray();
                        if(isset($names[$k])) {
                            $mParameter->setName($names[$k]);
                        }
                    }
                    
                    $values = $mParameter->getValue();
                    $values[MParameter::COLUMN_SECURITY_NUMBER] = $request->request->get('key');
                    $mParameter->setValue($values);
                    
                    $em->persist($mParameter);
                    $em->flush();
                    $con->commit();
                    return $this->redirectToRoute('kmj_user_login');
                } catch (\Exception $ex) {
                    $con->rollBack();
                    $this->addFlash("error", "error : ". $ex->getMessages());
                }*/
            }
        }
        return $this->render('@SerialNumber/security/invalid-serial-number.html.twig');
    }
    
}
