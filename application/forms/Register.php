<?php

class Application_Form_Register extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	
    	$firstname = new Zend_Form_Element_Text('firstname');
    	$firstname->setRequired(true)
    			->addFilter('StringTrim')
    			->addValidators(array(
    				array('NotEmpty' => true),
    				array('StringLength', true, array('min' => 2, 'max' => 30)),
    				array('Alpha')	
    			));
    	
    	$lastname = new Zend_Form_Element_Text('lastname');
    	
    	$password = new Zend_Form_Element_Password('password');
    	
    	$confirm = new Zend_Form_Element_Password('confirm');
    	
    	$email = new Zend_Form_Element_Text('email');
    	
    	$username = new Zend_Form_Element_Text('username');
    	
    	$company = new Zend_Form_Element_Text('company');
    	
    	$mobile = new Zend_Form_Element_Text('mobile');
    	
    	$website = new Zend_Form_Element_Text('website');
    	
    	$timezone = new Zend_Form_Element_Select('timezone');
    	
    	$businessType = new Zend_Form_Element_Select('businessType');
    	
    	$btnRegister = new Zend_Form_Element_Submit('btnRegister');
    	
    	
    	$this->addElements(array(
    			$btnRegister, 
    			$businessType, 
    			$firstname, 
    			$lastname, 
    			$password,
    			$email,
    			$confirm,
    			$timezone,
    			$website,
    			$company,
    			$mobile,
    			$username));
    	
    	
    	
    }


}

