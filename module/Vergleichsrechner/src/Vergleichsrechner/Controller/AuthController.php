<?php

namespace Vergleichsrechner\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Vergleichsrechner\Form\LoginForm;
use Vergleichsrechner\Form\LoginFilter;

class AuthController extends BaseController
{
	
	const ROUTE_CHANGEPASSWD = '/changepassword';
	const ROUTE_LOGIN        = 'login';
	const ROUTE_REGISTER     = '/register';
	const ROUTE_CHANGEEMAIL  = '/changeemail';
	
	const ROUTE_LOGIN_REDIRECT = 'welcome';
	const USE_REDIRECT_PARAMETERS_IF_PRESENT = true;
	
	const CONTROLLER_NAME    = 'Vergleichsrechner\Controller\Auth';

	protected $failedLoginMessage = 'Authentication failed. Please try again.';
	
	/**
	 * User page
	 */
	public function indexAction(){
		if (!$this->getServiceLocator()->get('Zend\Authentication\AuthenticationService')->hasIdentity()) {
			return $this->redirect()->toRoute(static::ROUTE_LOGIN);
		}
		return new ViewModel();
	}	
	/*
	 * Login page
	 */
	public function loginAction(){
		$authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
		$form = new LoginForm();
		$message = null;
		
		$request = $this->getRequest();

		if ($request->isPost() && $authService->getStorage()->isEmpty()) {
			$form->setInputFilter(new LoginFilter($this->getServiceLocator()));
            $form->setData($request->getPost());
			if ($form->isValid()) {
				$data = $form->getData();
				
				$adapter = $authService->getAdapter();
				$adapter->setIdentityValue($data['userEmail']);
				$adapter->setCredentialValue($data['userPassword']);
				$authResult = $authService->authenticate();
				if ($authResult->isValid()) {
					$identity = $authResult->getIdentity();
					$authService->getStorage()->write($identity);
					$time = 1209600; // 14 days 1209600/3600 = 336 hours => 336/24 = 14 days
					if ($data['rememberme']) {
						$sessionManager = new \Zend\Session\SessionManager();
						$sessionManager->rememberMe($time);
					}
				} 
				foreach ($authResult->getMessages() as $message) {
						$message .= "$message\n";
				}  	
			} 
		} 
		
		if (!$authService->getStorage()->isEmpty()) {
			return $this->redirect()->toRoute(static::ROUTE_LOGIN_REDIRECT);
		}
		return new ViewModel(array(
				'error' => 'Logindaten fehlerhaft',
				'form' => $form,
				'message' => $message,
		));
	}
	/**
	 * Logout and clear the identity
	 */
	public function logoutAction(){
		$authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
		$adapter = $authService->getAdapter();
		
		$authService->clearIdentity();
		$authService->getStorage()->clear();
		
		$redirect = $this->params()->fromPost('redirect', $this->params()->fromQuery('redirect', false));
	
		if (static::USE_REDIRECT_PARAMETERS_IF_PRESENT && $redirect) {
			return $this->redirect()->toUrl($redirect);
		}
	
		return $this->redirect()->toRoute(static::ROUTE_LOGIN);
	}
}