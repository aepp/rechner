<?php

namespace Vergleichsrechner\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


/**
 * WelcomeController
 * 
 * @author A.Epp
 * @version 1.0
 */
class WelcomeController extends AbstractActionController
{
	/**
	 * The default action - show the home page
	 */
    public function indexAction()
    {
     	// TODO Auto-generated {0}::indexAction() default action
    	return new ViewModel();
    }
}