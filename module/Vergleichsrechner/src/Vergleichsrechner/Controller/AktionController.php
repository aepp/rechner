<?php

namespace Vergleichsrechner\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Json\Json;
use Vergleichsrechner\Entity\Aktion;

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
	    		
	    		$aktionName = $_POST['aktionName'];
	    		$aktionBeschreibung = $_POST['aktionBeschreibung'];
	    		$aktionStartOn = date_create($_POST['aktionStartOn']);
	    		$aktionEndeOn = date_create($_POST['aktionEndeOn']);
	    		$aktionIsZuende = $_POST['aktionIsZuende'];
	    		$banken = $_POST['banken'];
	
	    		$aktion = new Aktion();
	    		$aktion->setAktionName($aktionName);
	    		$aktion->setAktionBeschreibung($aktionBeschreibung);
	    		$aktion->setAktionStartOn($aktionStartOn);
	    		$aktion->setAktionEndeOn($aktionEndeOn);
	    		$aktion->setAktionIsZuende($aktionIsZuende);

	    		if(is_array($banken)){
					foreach($banken as $id):
						$bank = $em->find('Vergleichsrechner\Entity\Bank', $id);
						$aktion->addBank($bank);
						$em->persist($bank);
					endforeach;
	    		} else {
	    			$bank = $em->find('Vergleichsrechner\Entity\Bank', $banken);
	    			$aktion->addBank($bank);
	    			$em->persist($bank);
	    		}
	    		
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
    		
    		$aktionName = $_POST['aktionName'];
    		$aktionBeschreibung = $_POST['aktionBeschreibung'];
    		$aktionStartOn = date_create($_POST['aktionStartOn']);
    		$aktionEndeOn = date_create($_POST['aktionEndeOn']);
    		$aktionIsZuende = $_POST['aktionIsZuende'];
    		$bankenNew = $_POST['banken'];
    		$bankenOld = $aktion->getBanken();
    		
    		$aktion->setAktionName($aktionName);
    		$aktion->setAktionBeschreibung($aktionBeschreibung);
    		$aktion->setAktionStartOn($aktionStartOn);
    		$aktion->setAktionEndeOn($aktionEndeOn);
    		$aktion->setAktionIsZuende($aktionIsZuende);
    		
//     		foreach($bankenOld as $id):
// 			if($bankenOld != null){
	    		$bank = $em->find('Vergleichsrechner\Entity\Bank', $bankenOld->get(0)->getBankId());
	    		$aktion->removeBank($bank);
	    		$em->persist($bank);
// 			}
//     		endforeach;
//     		foreach($bankenNew as $id):
	    		$bank = $em->find('Vergleichsrechner\Entity\Bank', $bankenNew);
	    		$aktion->addBank($bank);
	    		$em->persist($bank);
//     		endforeach;    	
    			
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