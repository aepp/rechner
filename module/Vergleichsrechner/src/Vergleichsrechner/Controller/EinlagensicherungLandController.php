<?php

namespace Vergleichsrechner\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Json\Json;
use Vergleichsrechner\Entity\EinlagensicherungLand;

/**
 * EinlagensicherungLandController
 * 
 * @author A. Epp
 * @version 1.0
 */
class EinlagensicherungLandController extends BaseController
{
	/**
	 * The default action - show the home page
	 */
    public function indexAction()
    {
     	// TODO Auto-generated EinlagensicherungLandController::indexAction() default action
    	return new ViewModel();
    }
    
    public function listAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$records = $em->getRepository('Vergleichsrechner\Entity\EinlagensicherungLand')
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
    		$einlagensicherungLandName = $_POST['einlagensicherungLandName'];
    		$einlagensicherungLand = new EinlagensicherungLand();
    		$einlagensicherungLand->setEinlagensicherungLandName($einlagensicherungLandName);
    		$em->persist($einlagensicherungLand);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $einlagensicherungLand->jsonSerialize())));
    	}
    	return $response;
    }
    public function updateAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['einlagensicherungLandId'];
    		$einlagensicherungLand = $em->find('Vergleichsrechner\Entity\EinlagensicherungLand', $id);
    		
    		$einlagensicherungLandName = $_POST['einlagensicherungLandName'];
    		
    		$einlagensicherungLand->setEinlagensicherungLandName($einlagensicherungLandName);
    		$em->persist($einlagensicherungLand);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $einlagensicherungLand->jsonSerialize())));
    	}
    	return $response;
    }
    public function deleteAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['einlagensicherungLandId'];
    		$einlagensicherungLand = $em->find('Vergleichsrechner\Entity\EinlagensicherungLand', $id);
    
    		$em->remove($einlagensicherungLand);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK')));
    	}
    	return $response;
    }
}