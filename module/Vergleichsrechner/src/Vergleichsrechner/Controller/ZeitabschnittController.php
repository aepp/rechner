<?php

namespace Vergleichsrechner\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Json\Json;
use Vergleichsrechner\Entity\Zeitabschnitt;

/**
 * ZeitabschnittController
 * 
 * @author A. Epp
 * @version 1.0
 */
class ZeitabschnittController extends BaseController
{
	/**
	 * The default action - show the home page
	 */
    public function indexAction()
    {
     	// TODO Auto-generated ZeitabschnittController::indexAction() default action
    	return new ViewModel();
    }
    
    public function listAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$records = $em->getRepository('Vergleichsrechner\Entity\Zeitabschnitt')
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
    		$zeitabschnittName = $_POST['zeitabschnittName'];
    		$zeitabschnitt = new Zeitabschnitt();
    		$zeitabschnitt->setZeitabschnittName($zeitabschnittName);
    		$em->persist($zeitabschnitt);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $zeitabschnitt->jsonSerialize())));
    	}
    	return $response;
    }
    public function updateAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['zeitabschnittId'];
    		$zeitabschnitt = $em->find('Vergleichsrechner\Entity\Zeitabschnitt', $id);
    		
    		$zeitabschnittName = $_POST['zeitabschnittName'];
    		
    		$zeitabschnitt->setZeitabschnittName($zeitabschnittName);
    		$em->persist($zeitabschnitt);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $zeitabschnitt->jsonSerialize())));
    	}
    	return $response;
    }
    public function deleteAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['zeitabschnittId'];
    		$zeitabschnitt = $em->find('Vergleichsrechner\Entity\Zeitabschnitt', $id);
    
    		$em->remove($zeitabschnitt);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK')));
    	}
    	return $response;
    }
}