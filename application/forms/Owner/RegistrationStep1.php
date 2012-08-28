<?php
class Owner_RegistrationStep1 extends Zend_Form{
	public function init(){
		$this->setMethod(Zend_Form::METHOD_POST);
		$this->addDecorators(array("ViewHelper"), array("Errors"));
		$firstname = new Zend_Form_Element_Text("first_name");
		$firstname->setLabel("Firstname");
		$firstname->setRequired(true);
		$firstname->addValidators(array(
		array("validator"=>"NotEmpty",
				  "breakChainOnFailure"=>true),
		array("validator"=>"alpha",
				"options"=>array("allowWhiteSpace"=>false)),
		array("validator"=>"stringLength",
				"options"=>array(6, 50))
			
		));
		$lastname = new Zend_Form_Element_Text("last_name");
		$lastname->setLabel("Lastname");
		$lastname->setRequired(true);
		$lastname->addValidators(array(
		array("validator"=>"NotEmpty",
				  "breakChainOnFailure"=>true),
		array("validator"=>"alpha",
				"options"=>array("allowWhiteSpace"=>false)),
		array("validator"=>"stringLength",
				"options"=>array(6, 50))
			
		));
		$email = new Zend_Form_Element_Text("email");
		$email->setLabel("Email Address");
		$email->setRequired(true);
		$email->addValidators(array(
		array("validator"=>"NotEmpty",
				  "breakChainOnFailure"=>true)),
		array("validator"=>"emailAddress"),
		array("validator"=>"stringLength",
				"options"=>array(6, 50))			
		);
		$confirm_email = new Zend_Form_Element_Text("confirm_email");
		$confirm_email->setLabel("Confirm Email Address");
		$confirm_email->setRequired(true);
		$confirm_email->addValidators(array(
		array("validator"=>"NotEmpty",
				  "breakChainOnFailure"=>true)),
		array("validator"=>"emailAddress"),
		array("validator"=>"stringLength",
				"options"=>array(6, 50))			
		);
		
		$this->addElements(array($firstname, $lastname, $email, $confirm_email));
		
	}
}
