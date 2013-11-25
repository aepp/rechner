<?php

namespace Vergleichsrechner\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Json\Json;
use Vergleichsrechner\Entity\Testbericht;

/**
 * TestberichtController
 * 
 * @author A. Epp
 * @version 1.0
 */
class TestberichtController extends BaseController
{
	/**
	 * The default action - show the home page
	 */
    public function indexAction()
    {
     	// TODO Auto-generated TestberichtController::indexAction() default action
    	return new ViewModel();
    }
    
    public function listAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$records = $em->getRepository('Vergleichsrechner\Entity\Testbericht')
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
    		$testberichtName = $_POST['testberichtName'];
    		$testbericht = new Testbericht();
    		$testbericht->setTestberichtName($testberichtName);
    		$em->persist($testbericht);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $testbericht->jsonSerialize())));
    	}
    	return $response;
    }
    public function updateAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['testberichtId'];
    		$testbericht = $em->find('Vergleichsrechner\Entity\Testbericht', $id);
    		
    		$testberichtName = $_POST['testberichtName'];
    		
    		$testbericht->setTestberichtName($testberichtName);
    		$em->persist($testbericht);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $testbericht->jsonSerialize())));
    	}
    	return $response;
    }
    public function deleteAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['testberichtId'];
    		$testbericht = $em->find('Vergleichsrechner\Entity\Testbericht', $id);
    
    		$em->remove($testbericht);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK')));
    	}
    	return $response;
    }
}