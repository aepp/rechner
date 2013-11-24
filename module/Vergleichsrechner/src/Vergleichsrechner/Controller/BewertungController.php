<?php

namespace Vergleichsrechner\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Json\Json;
use Vergleichsrechner\Entity\Bewertung;

/**
 * {0}
 * 
 * @author A. Epp
 * @version 1.0
 */
class BewertungController extends BaseController
{
	/**
	 * The default action - show the home page
	 */
    public function indexAction()
    {
     	// TODO Auto-generated {0}::indexAction() default action
    	return new ViewModel();
    }
    
    public function listAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$records = $em->getRepository('Vergleichsrechner\Entity\Bewertung')
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
    		$bewertungName = $_POST['bewertungName'];
    		$bewertung = new Bewertung();
    		$bewertung->setBewertungName($bewertungName);
    		$em->persist($bewertung);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $bewertung->jsonSerialize())));
    	}
    	return $response;
    }
    public function updateAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['bewertungId'];
    		$bewertung = $em->find('Vergleichsrechner\Entity\Bewertung', $id);
    		
    		$bewertungName = $_POST['bewertungName'];
    		
    		$bewertung->setBewertungName($bewertungName);
    		$em->persist($bewertung);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $bewertung->jsonSerialize())));
    	}
    	return $response;
    }
    public function deleteAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['bewertungId'];
    		$bewertung = $em->find('Vergleichsrechner\Entity\Bewertung', $id);
    
    		$em->remove($bewertung);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK')));
    	}
    	return $response;
    }
}