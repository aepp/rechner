<?php

namespace Vergleichsrechner\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Vergleichsrechner\Form\AddProductForm;


/**
 * ProductController
 * 
 * @author A. Epp
 * @version 1.0
 */
class ProduktController extends BaseController
{
	/**
	 * The default action - show the home page
	 */
    public function indexAction()
    {
     	// TODO Auto-generated ProduktController::indexAction() default action
    	return new ViewModel();
    }
    
    public function addAction()
    {
    	$forms = $this->getServiceLocator()->get('FormElementManager');
		$form = $forms->get('AddProductForm', array('name' => 'formName', 'options' => array()));
		return new ViewModel(array(
				'form' => $form,
		));
    }    
    
}