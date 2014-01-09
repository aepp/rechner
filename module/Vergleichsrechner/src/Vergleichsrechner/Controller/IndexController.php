<?php

namespace Vergleichsrechner\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


/**
 * IndexController
 * 
 * @author A.Epp
 * @version 1.0
 */
class IndexController extends AbstractActionController
{
	/**
	 * The default action - show the home page
	 */
    public function indexAction()
    {
     	// TODO Auto-generated IndexController::indexAction() default action
    	return new ViewModel();
    }
}