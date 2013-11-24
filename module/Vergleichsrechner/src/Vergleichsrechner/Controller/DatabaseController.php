<?php

namespace Vergleichsrechner\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Json\Json;

/**
 * {0}
 * 
 * @author A. Epp
 * @version 1.0
 */
class DatabaseController extends AbstractActionController
{
	/**
	 * The default action - show the home page
	 */
    public function indexAction()
    {
    	return new ViewModel();
    }
}