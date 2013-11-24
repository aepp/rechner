<?php

namespace Vergleichsrechner\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Json\Json;
use Vergleichsrechner\Entity\Kontozugriff;

/**
 * KontozugriffController
 * 
 * @author A. Epp
 * @version 1.0
 */
class KontozugriffController extends BaseController
{
	/**
	 * The default action - show the home page
	 */
    public function indexAction()
    {
     	// TODO Auto-generated KontozugriffController::indexAction() default action
    	return new ViewModel();
    }
    
    public function listAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$records = $em->getRepository('Vergleichsrechner\Entity\Kontozugriff')
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
    		$kontozugriffName = $_POST['kontozugriffName'];
    		$kontozugriff = new Kontozugriff();
    		$kontozugriff->setKontozugriffName($kontozugriffName);
    		$em->persist($kontozugriff);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $kontozugriff->jsonSerialize())));
    	}
    	return $response;
    }
    public function updateAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['kontozugriffId'];
    		$kontozugriff = $em->find('Vergleichsrechner\Entity\Kontozugriff', $id);
    		
    		$kontozugriffName = $_POST['kontozugriffName'];
    		
    		$kontozugriff->setKontozugriffName($kontozugriffName);
    		$em->persist($kontozugriff);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $kontozugriff->jsonSerialize())));
    	}
    	return $response;
    }
    public function deleteAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['kontozugriffId'];
    		$kontozugriff = $em->find('Vergleichsrechner\Entity\Kontozugriff', $id);
    
    		$em->remove($kontozugriff);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK')));
    	}
    	return $response;
    }
}