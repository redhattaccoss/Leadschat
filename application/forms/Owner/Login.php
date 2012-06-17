<?php 
class Owner_Login extends Zend_Form{
	public function init(){
		$this->addDecorators(array("ViewHelper"), array("Errors"));
		$username = new Zend_Form_Element_Text("username");
		$username->setRequired(true);
		$username->setLabel("Username");
		$username->addValidators(array(
		array("validator"=>"NotEmpty")),
		array("validator"=>"alpha",
				  "options"=>array("allowWhiteSpace"=>false)),
		array("validator"=>"stringLength",
				"options"=>array(6, 30))			
		);
		$password = new Zend_Form_Element_Password("password");
		$password->setRequired(true);
		$password->setLabel("Password");
		$password->addValidators(array(
		array("validator"=>"NotEmpty")),
		array("validator"=>"alnum",
				  "options"=>array("allowWhiteSpace"=>false)),
		array("validator"=>"stringLength",
				"options"=>array(6, 30))			
		);
		$rememberMe = new Zend_Form_Element_Checkbox("remember_me");
		$this->setMethod(Zend_Form::METHOD_POST);		
		$this->addElements(array($username, $password, $rememberMe));
	}
}