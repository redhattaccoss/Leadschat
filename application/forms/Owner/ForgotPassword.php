<?php
class Owner_ForgotPassword extends Zend_Form{
	public function init(){
		$this->addDecorators(array("ViewHelper"), array("Errors"));
		$emailAddress = new Zend_Form_Element_Text("email_address");
		$emailAddress->setLabel("Email address");
		$emailAddress->setRequired(true);
		$emailAddress->addValidators(array(
		array("validator"=>"NotEmpty",
				  "breakChainOnFailure"=>true)),
		array("validator"=>"emailAddress"),
		array("validator"=>"stringLength",
				"options"=>array(6, 50)));
		$this->setMethod(Zend_Form::METHOD_POST);
		$this->addElement($emailAddress);
	}
}