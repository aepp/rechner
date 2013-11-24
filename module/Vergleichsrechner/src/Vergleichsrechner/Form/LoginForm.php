<?php
namespace Vergleichsrechner\Form;

use Zend\Form\Form;

class LoginForm extends Form{
    public function __construct(){
        parent::__construct('login');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'userEmail',
            'attributes' => array(
                'type' => 'text',
            	'class' => 'form-control',
            	'placeholder' => 'Email',
            	'required' => '',
            	'autofocus' => '',	
            ),
        ));
        $this->add(array(
            'name' => 'userPassword',
            'attributes' => array(
                'type' => 'password',
            	'class' => 'form-control',
            	'placeholder' => 'Password',
            	'required' => '',
            ),
        ));

        $this->add(array(
            'name' => 'rememberme',
			'type' => 'checkbox', // 'Zend\Form\Element\Checkbox',
        		'label' => 'Remember Me?',
            'attributes' => array(
                'label' => 'Remember Me?',
//            	'checked_value' => 'true', without value here will be 1
//          	'unchecked_value' => 'false', // witll be 1
            ),
        ));        

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Login',
                'id' => 'button_login',
            	'class' => 'btn btn-lg btn-primary btn-block',
            ),
        ));
    }
}