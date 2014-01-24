<?php

namespace Vergleichsrechner\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Json\Json;
use Vergleichsrechner\Entity\Erfahrung;
use Vergleichsrechner\Entity\Bank;

require __DIR__.'/../Exception/ErrorHandler.php';

/**
 * ErfahrungController
 * 
 * @author A. Epp
 * @version 1.0
 */
class ErfahrungController extends BaseController
{
    public function indexAction()
    {
    	$message = null;
    	$error = false;
    	$produkte = array();
    	
    	try{
    		$em = $this->getEntityManager();
    		$erfahrungen = $em->getRepository('Vergleichsrechner\Entity\Erfahrung')->findAll();
    		$banken = $em->getRepository('Vergleichsrechner\Entity\Bank')->findAll();
    	} catch (\Exception $e){
    		$message = $e->getMessage();
    		$error = true;
    	}
    	return new ViewModel(array(
    			'erfahrungen' => $erfahrungen,
    			'banken' => $banken,
    			'message' => $message,
    			'error' => $error
    	));     	
    	return new ViewModel();
    }
    
    public function listAction()
    {
    }
    public function updateAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		try{
    			$em = $this->getEntityManager();
    			$erfahrungId = $this->params()->fromRoute('erfahrungId');
    			$erfahrung = $em->find('Vergleichsrechner\Entity\Erfahrung', $erfahrungId);
    			 
    			$erfahrungIsFreigeschaltet = $this->params()->fromPost('status');
    			 
    			$erfahrung->setErfahrungIsFreigeschaltet($erfahrungIsFreigeschaltet);
    			 
    			$em->persist($erfahrung);
    			$em->flush();
    		} catch (Exception $e){

    		}
    	}
    	return new JsonModel(array(
    	));
    }
    public function deleteAction()
    {
    }
}