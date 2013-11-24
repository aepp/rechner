<?php

namespace Vergleichsrechner\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Json\Json;
use Vergleichsrechner\Entity\User;

/**
 * UserController
 * 
 * @author A. Epp
 * @version 1.0
 */
class UserController extends BaseController
{
	/**
	 * The default action - show the home page
	 */
    public function indexAction()
    {
     	// TODO Auto-generated UserController::indexAction() default action
    	return new ViewModel();
    }
    
    public function listAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$users = $em->getRepository('Vergleichsrechner\Entity\User')
    					->findAllJT($_GET['jtSorting'], $_GET['jtStartIndex'], $_GET['jtPageSize']);
    		$json = array();
    		foreach ($users as $user){
    			array_push($json, $user->jsonSerialize());
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
    		$user = new User();
    		
    		$userName = $_POST['userName'];
    		$userVorname = $_POST['userVorname'];
    		$userEmail = $_POST['userEmail'];
    		$userSalt = hash('md5', $user->getUserId().$userEmail);
    		$userPassword = hash('md5', $_POST['userPassword'].$userSalt);
    		
    		$user->setUserName($userName);
    		$user->setUserVorname($userVorname);
    		$user->setUserEmail($userEmail);
    		$user->setUserPassword($userPassword);
    		$user->setUserSalt($userSalt);
    		
    		$em->persist($user);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $user->jsonSerialize())));
    	}
    	return $response;
    }
    public function updateAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['userId'];
    		$user = $em->find('Vergleichsrechner\Entity\User', $id);
    
    		$userName = $_POST['userName'];
    		$userVorname = $_POST['userVorname'];
    		$userEmail = $_POST['userEmail'];
    		$userSalt = hash('md5', $user->getUserId().$userEmail);
    		$userPassword = $_POST['userPassword'];
    		$hashedPassword = hash('md5', $userPassword.$userSalt);
    		if(strcmp($userPassword, $user->getUserPassword()) == 0
    			&& strcmp($userEmail, $user->getUserEmail()) == 0){
    			$hashedPassword = $user->getUserPassword();
    		}
    		
    		$user->setUserName($userName);
    		$user->setUserVorname($userVorname);
    		$user->setUserEmail($userEmail);
    		$user->setUserPassword($hashedPassword);
    		$user->setUserSalt($userSalt);
    		
    		$em->persist($user);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK', 'Record' => $user->jsonSerialize())));
    	}
    	return $response;
    }
    public function deleteAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	if ($request->isPost()) {
    		$em = $this->getEntityManager();
    		$id = $_POST['userId'];
    		$user = $em->find('Vergleichsrechner\Entity\User', $id);
    
    		$em->remove($user);
    		$em->flush();
    		$response->setContent(Json::encode(array('Result' => 'OK')));
    	}
    	return $response;
    }
}