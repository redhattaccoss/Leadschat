<?php
class Owner_ResetPassword extends Zend_Form{
	public function init(){
		$this->addDecorators(array("ViewHelper"), array("Errors"));
		
		
		$new_password = new Zend_Form_Element_Password("new_password");
		$new_password->setLabel("New Password");
		$new_password->setRequired(true);
		$new_password->addValidators(array(
		array("validator"=>"NotEmpty",
				  "breakChainOnFailure"=>true)),
		array("validator"=>"alnum",
				  "options"=>array("allowWhiteSpace"=>false)),
		array("validator"=>"stringLength",
				"options"=>array(6, 30))			
		);


		$confirm_password = new Zend_Form_Element_Password("confirm_password");
		$confirm_password->setLabel("Confirm New Password");
		$confirm_password->setRequired(true);
		$confirm_password->addValidators(array(
		array("validator"=>"NotEmpty",
				  "breakChainOnFailure"=>true)),
		array("validator"=>"alnum",
				  "options"=>array("allowWhiteSpace"=>false)),
		array("validator"=>"stringLength",
				"options"=>array(6, 30))			
		);
		
		
		$owner_id = new Zend_Form_Element_Hidden("owner_id");
		$owner_id->setRequired(true);
		
		$this->addElements(array($new_password, $confirm_password, $owner_id));
	}
}
