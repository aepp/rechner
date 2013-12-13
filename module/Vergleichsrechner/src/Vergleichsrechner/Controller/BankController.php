<?php

namespace Vergleichsrechner\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Json\Json;
use Vergleichsrechner\Entity\Bank;

/**
 * BankController
 * 
 * @author A. Epp
 * @version 1.0
 */
class BankController extends BaseController
{
	/**
	 * The default action - show the home page
	 */
    public function indexAction()
    {
     	// TODO Auto-generated BankController::indexAction() default action
    	return new ViewModel();
    }
    
    public function listAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$records = $em->getRepository('Vergleichsrechner\Entity\Bank')
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
	    		$bankName = $_POST['bankName'];
	    		$bankLogo = $_POST['bankLogo'];
	    		
	    		$bank = new Bank();
	    		$bank->setBankName($bankName);
	    		$bank->setBankLogo($bankLogo);
	    		
	    		$em->persist($bank);
	    		$em->flush();
	    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $bank->jsonSerialize())));
    		} catch (Exception $e){
    			$response->setContent(Json::encode(array('Result' => 'Error', 'Message' => $e->getMessage())));
    		}
    	}
    	return $response;
    }
    public function updateAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		try{
	    		$em = $this->getEntityManager();
	    		$id = $_POST['bankId'];
	    		$bank = $em->find('Vergleichsrechner\Entity\Bank', $id);
	    		
	    		$bankName = $_POST['bankName'];
	    		$bankLogo = $_POST['bankLogo'];
	    		
	    		$bank->setBankName($bankName);
	    		$bank->setBankLogo($bankLogo);
	    		
	    		$em->persist($bank);
	    		$em->flush();
	    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $bank->jsonSerialize())));
    		} catch (Exception $e){
    			$response->setContent(Json::encode(array('Result' => 'Error', 'Message' => $e->getMessage())));
    		}
    	}
    	return $response;
    }
    public function deleteAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		try{
	    		$em = $this->getEntityManager();
	    		$id = $_POST['bankId'];
	    		$bank = $em->find('Vergleichsrechner\Entity\Bank', $id);
	    		$bank_logo = $bank->getBankLogo();
	    		
	    		$em->remove($bank);
	    		$em->flush();
	    		$response->setContent(Json::encode(array('Result' => 'OK')));
	    		if(file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/bank-logo/'.$bank_logo)){
	    			unlink($_SERVER['DOCUMENT_ROOT'].'/uploads/bank-logo/'.$bank_logo);
	    			unlink('/var/www/vhosts/vergleich24.at/httpdocs/wp-content/uploads/bank-logo/'.$bank_logo);
	    		}
    		} catch (Exception $e){
    			$response->setContent(Json::encode(array('Result' => 'Error', 'Message' => $e->getMessage())));
    		}
    	}
    	return $response;
    }
    
    /*
     * Returns a json-Object with list of Bank
     * for select in Aktion-table
     * 
     */
    public function optionsAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$banken = $em->getRepository('Vergleichsrechner\Entity\Bank')->findAll();
    		$options = array();
    		$option = array();
    		foreach ($banken as $bank){
    			$option = array('Value' => $bank->getBankId(), 'DisplayText' => $bank->getBankName());
    			array_push($options, $option);
    		}
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Options' => $options)));
    	}
    	return $response;
    }    
}