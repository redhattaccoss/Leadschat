<?php
class Owner_RegistrationStep3 extends Zend_Form{
	public function init(){
		$this->addDecorators(array("ViewHelper"), array("Errors"));
		
	}
}