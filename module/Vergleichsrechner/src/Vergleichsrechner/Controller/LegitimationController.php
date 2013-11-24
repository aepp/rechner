<?php

namespace Vergleichsrechner\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Json\Json;
use Vergleichsrechner\Entity\Legitimation;

/**
 * LegitimationController
 * 
 * @author A. Epp
 * @version 1.0
 */
class LegitimationController extends BaseController
{
	/**
	 * The default action - show the home page
	 */
    public function indexAction()
    {
     	// TODO Auto-generated LegitimationController::indexAction() default action
    	return new ViewModel();
    }
    
    public function listAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$records = $em->getRepository('Vergleichsrechner\Entity\Legitimation')
    					  ->findAllJT($_GET['jtSorting'], $_GET['jtStartIndex'], $_GET['jtPageSize']);
    		$json = array();
    		foreach ($records as $record){
    			array_push($json, $record->jsonSerialize());
    		}
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Records' => $json, 'TotalRecordCount' => count($json))));
    	}
    	return $response;
    }
    
    public function createAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$legitimationName = $_POST['legitimationName'];
    		$legitimation = new Legitimation();
    		$legitimation->setLegitimationName($legitimationName);
    		$em->persist($legitimation);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $legitimation->jsonSerialize())));
    	}
    	return $response;
    }
    public function updateAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['legitimationId'];
    		$legitimation = $em->find('Vergleichsrechner\Entity\Legitimation', $id);
    		
    		$legitimationName = $_POST['legitimationName'];
    		
    		$legitimation->setLegitimationName($legitimationName);
    		$em->persist($legitimation);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $legitimation->jsonSerialize())));
    	}
    	return $response;
    }
    public function deleteAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['legitimationId'];
    		$legitimation = $em->find('Vergleichsrechner\Entity\Legitimation', $id);
    
    		$em->remove($legitimation);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK')));
    	}
    	return $response;
    }
}