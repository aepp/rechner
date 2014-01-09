<?php

namespace Vergleichsrechner\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


/**
 * ProduktverwaltungController
 * 
 * @author A.Epp
 * @version 1.0
 */
class ProduktverwaltungController extends AbstractActionController
{
	/**
	 * The default action - show the Produktverwaltung home page
	 */
    public function indexAction()
    {
     	// TODO Auto-generated ProduktverwaltungController::indexAction() default action
    	return new ViewModel();
    }
}