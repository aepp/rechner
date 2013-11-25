<?php

namespace Vergleichsrechner\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Json\Json;
use Vergleichsrechner\Entity\Aktion;
use Vergleichsrechner\Controller\BaseController;

require __DIR__.'/../Exception/ErrorHandler.php';

/**
 * AktionController
 * 
 * @author A. Epp
 * @version 1.0
 */
class AktionController extends BaseController
{
	/**
	 * The default action - show the home page
	 */
    public function indexAction()
    {
     	// TODO Auto-generated AktionController::indexAction() default action
    	return new ViewModel();
    }
    
    public function listAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$em->flush();
    		$records = $em->getRepository('Vergleichsrechner\Entity\Aktion')
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
    		try{
	    		$em = $this->getEntityManager();
	    		$aktionBeschreibung = $_POST['aktionBeschreibung'];
	    		$aktionStartOn = date_create($_POST['aktionStartOn']);
	    		$aktionEndeOn = date_create($_POST['aktionEndeOn']);
	    		$aktionIsZuende = $_POST['aktionIsZuende'];
	
	    		$aktion = new Aktion();
	    		$aktion->setAktionBeschreibung($aktionBeschreibung);
	    		$aktion->setAktionStartOn($aktionStartOn);
	    		$aktion->setAktionEndeOn($aktionEndeOn);
	    		$aktion->setAktionIsZuende($aktionIsZuende);
	    		$em->persist($aktion);
	    		$em->flush();
	    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $aktion->jsonSerialize())));
    		} catch (ErrorException $e) {
    			$response->setContent(Json::encode(array('Result' => 'ERROR', 'Message' => $e->getMessage())));
    		}
    	}
    	return $response;
    }
    public function updateAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['aktionId'];
    		$aktion = $em->find('Vergleichsrechner\Entity\Aktion', $id);
    		
    		$aktionBeschreibung = $_POST['aktionBeschreibung'];
    		$aktionStartOn = date_create($_POST['aktionStartOn']);
    		$aktionEndeOn = date_create($_POST['aktionEndeOn']);
    		$aktionIsZuende = $_POST['aktionIsZuende'];
    		
    		$aktion->setAktionBeschreibung($aktionBeschreibung);
    		$aktion->setAktionStartOn($aktionStartOn);
    		$aktion->setAktionEndeOn($aktionEndeOn);
    		$aktion->setAktionIsZuende($aktionIsZuende);
    		
    		$em->persist($aktion);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $aktion->jsonSerialize())));
    	}
    	return $response;
    }
    public function deleteAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['aktionId'];
    		$aktion = $em->find('Vergleichsrechner\Entity\Aktion', $id);
    
    		$em->remove($aktion);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK')));
    	}
    	return $response;
    }
}