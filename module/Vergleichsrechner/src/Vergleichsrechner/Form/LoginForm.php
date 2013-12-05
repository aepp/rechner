<?php
namespace Vergleichsrechner\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class LoginForm extends Form{
    public function __construct()
    {
        parent::__construct('login');

        $labelAttributes = array('class' => 'col-sm-3 control-label');
        
        $email = new Element\Text();
        $password = new Element\Password();
        $rememberme = new Element\Checkbox();
        $login = new Element\Button();
        
        $email
			->setName('userEmail')
			->setLabel('Email')
			->setLabelAttributes($labelAttributes)
			->setAttributes(array(
					'class' => 'form-control validate[required]',
					'id' => 'userEmail',
					'placeholder' => 'Email',
					'required' => '',
					'autofocus' => '',
			));	
			
		$password
			->setName('userPassword')
			->setLabel('Password')
			->setLabelAttributes($labelAttributes)
			->setAttributes(array(
					'class' => 'form-control validate[required]',
					'id' => 'userEmail',
					'placeholder' => 'Password',
					'required' => '',
			));     
			   
		$rememberme
			->setName('rememberme')
			->setLabel('Remember me?')
			->setAttributes(array(
					'id' => 'rememberme',
			));
			
		$login
			->setName('login-button')
			->setLabel('Log in')
			->setLabelAttributes($labelAttributes)
			->setAttributes(array(
					'class' => 'form-control',
					'id' => 'login-button',
					'class' => 'btn btn-lg btn-primary btn-block',
			));

		$this->setAttributes(array(
				'method' => 'post',
				'role' =>'form',
				'class' => 'form-horizontal',
				'id' => 'login-form'
		));
		
		$this->add($email);
		$this->add($password);
		$this->add($rememberme);
		$this->add($login);
    }
}