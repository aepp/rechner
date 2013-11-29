<?php

namespace Vergleichsrechner\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Json\Json;
use Vergleichsrechner\Entity\Zinssatz;

/**
 * ZinssatzController
 * 
 * @author A. Epp
 * @version 1.0
 */
class ZinssatzController extends BaseController
{
	/**
	 * The default action - show the home page
	 */
    public function indexAction()
    {
     	// TODO Auto-generated ZinssatzController::indexAction() default action
    	return new ViewModel();
    }
    
    public function listAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$records = $em->getRepository('Vergleichsrechner\Entity\Zinssatz')
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
    		$zinssatzName = $_POST['zinssatzName'];
    		$zinssatz = new Zinssatz();
    		$zinssatz->setZinssatzName($zinssatzName);
    		$em->persist($zinssatz);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $zinssatz->jsonSerialize())));
    	}
    	return $response;
    }
    public function updateAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['zinssatzId'];
    		$zinssatz = $em->find('Vergleichsrechner\Entity\Zinssatz', $id);
    		
    		$zinssatzName = $_POST['zinssatzName'];
    		
    		$zinssatz->setZinssatzName($zinssatzName);
    		$em->persist($zinssatz);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $zinssatz->jsonSerialize())));
    	}
    	return $response;
    }
    public function deleteAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['zinssatzId'];
    		$zinssatz = $em->find('Vergleichsrechner\Entity\Zinssatz', $id);
    
    		$em->remove($zinssatz);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK')));
    	}
    	return $response;
    }
}