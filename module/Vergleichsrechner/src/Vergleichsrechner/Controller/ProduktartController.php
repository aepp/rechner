<?php

namespace Vergleichsrechner\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Json\Json;
use Vergleichsrechner\Entity\Produktart;

/**
 * ProduktartController
 * 
 * @author A. Epp
 * @version 1.0
 */
class ProduktartController extends BaseController
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
    		$records = $em->getRepository('Vergleichsrechner\Entity\Produktart')
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
    		$produktartName = $_POST['produktartName'];
    		
    		$produktart = new Produktart();
    		$produktart->setProduktartName($produktartName);
    		$em->persist($produktart);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $produktart->jsonSerialize())));
    	}
    	return $response;
    }
    public function updateAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['produktartId'];
    		$produktart = $em->find('Vergleichsrechner\Entity\Produktart', $id);
    		$produktartName = $_POST['produktartName'];
    		$produktart->setProduktartName($produktartName);
    		$em->persist($produktart);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $produktart->jsonSerialize())));
    	}
    	return $response;
    }
    public function deleteAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['produktartId'];
    		$produktart = $em->find('Vergleichsrechner\Entity\Produktart', $id);
    
    		$em->remove($produktart);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK')));
    	}
    	return $response;
    }
}