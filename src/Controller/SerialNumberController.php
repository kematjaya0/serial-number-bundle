<?php

namespace Kematjaya\SerialNumberBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SerialNumberController extends AbstractController
{
    
    public function invalidSerialNumber(Request $request, \Symfony\Contracts\Translation\TranslatorInterface $trans, SerialNumberProvider $serialNumberProvider, MParameterRepository $mParameterRepo)
    {
        if($request->getMethod() == Request::METHOD_POST) {
            
            if(!$serialNumberProvider->validateSerialNumber($request->request->get('key'))) {
                $this->addFlash('error', $trans->trans('invalid_serial_number'));
                return $this->redirectToRoute('app_invalid_serial_number');
            }
            
            if ($this->isCsrfTokenValid('serial_number', $request->request->get('_csrf_token'))) {
                    
                $em = $this->getDoctrine()->getManager();
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
                }
            }
        }
        return $this->render('security/invalid-serial-number.html.twig');
    }
    
}
