<?php

namespace Vergleichsrechner\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Json\Json;
use Vergleichsrechner\Entity\RKVAbschluss;

/**
 * RKVAbschlussController
 * 
 * @author A. Epp
 * @version 1.0
 */
class RKVAbschlussController extends BaseController
{
	/**
	 * The default action - show the home page
	 */
    public function indexAction()
    {
     	// TODO Auto-generated RKVAbschlussController::indexAction() default action
    	return new ViewModel();
    }
    
    public function listAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$records = $em->getRepository('Vergleichsrechner\Entity\RKVAbschluss')
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
    		$rkvAbschlussName = $_POST['rkvAbschlussName'];
    		$rkvAbschluss = new RKVAbschluss();
    		$rkvAbschluss->setRKVAbschlussName($rkvAbschlussName);
    		$em->persist($rkvAbschluss);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $rkvAbschluss->jsonSerialize())));
    	}
    	return $response;
    }
    public function updateAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['rkvAbschlussId'];
    		$rkvAbschluss = $em->find('Vergleichsrechner\Entity\RKVAbschluss', $id);
    		
    		$rkvAbschlussName = $_POST['rkvAbschlussName'];
    		
    		$rkvAbschluss->setRKVAbschlussName($rkvAbschlussName);
    		$em->persist($rkvAbschluss);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $rkvAbschluss->jsonSerialize())));
    	}
    	return $response;
    }
    public function deleteAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['rkvAbschlussId'];
    		$rkvAbschluss = $em->find('Vergleichsrechner\Entity\RKVAbschluss', $id);
    
    		$em->remove($rkvAbschluss);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK')));
    	}
    	return $response;
    }
}