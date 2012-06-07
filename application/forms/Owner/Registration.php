<?php 
class Owner_Registration extends Zend_Form{
	public function init(){
		$firstname = new Zend_Form_Element_Text("first_name", array('disableLoadDefaultDecorators' => true));
		$firstname->setRequired(true);
		$lastname = new Zend_Form_Element_Text("last_name", array('disableLoadDefaultDecorators' => true));
		$lastname->setRequired(true);
		$website = new Zend_Form_Element_Text("website", array('disableLoadDefaultDecorators' => true));
		$website->setRequired(true);
		$username = new Zend_Form_Element_Text("username", array('disableLoadDefaultDecorators' => true));
		$username->setRequired(true);
		$password = new Zend_Form_Element_Password("password", array('disableLoadDefaultDecorators' => true));
		$password->setRequired(true);
		$confirm_password = new Zend_Form_Element_Password("confirm_password", array('disableLoadDefaultDecorators' => true));
		$confirm_password->setRequired(true);
		$email = new Zend_Form_Element_Text("email", array('disableLoadDefaultDecorators' => true));
		$email->setRequired(true);
		$mobile = new Zend_Form_Element_Text("mobile", array('disableLoadDefaultDecorators' => true));
		$mobile->setRequired(true);
		$fullname_webmaster = new Zend_Form_Element_Text("fullname_webmaster", array('disableLoadDefaultDecorators' => true));
		$email_webmaster = new Zend_Form_Element_Text("email_webmaster", array('disableLoadDefaultDecorators' => true));
		$phone_webmaster = new Zend_Form_Element_Text("phone_webmaster", array('disableLoadDefaultDecorators' => true));
		$company = new Zend_Form_Element_Text("company", array('disableLoadDefaultDecorators' => true));
		$company_contact = new Zend_Form_Element_Text("company_contact", array('disableLoadDefaultDecorators' => true));
		$number_hits = new Zend_Form_Element_Select("number_hits", 
								array('disableLoadDefaultDecorators' => true));
		$number_hits->setRequired(true);
		$businessType = new Zend_Form_Element_Select("business_type", 
								array('disableLoadDefaultDecorators' => true));
		$businessType->setRequired(true);
		$timezone = new Zend_Form_Element_Select("timezone_id", array('disableLoadDefaultDecorators' => true));
		$timezone->setRequired(true);
		$this->addElements(array($firstname,
			 					 $lastname,
			 					 $password,
			 					 $confirm_password,
			 					 $username,
			 					 $email,
			 					 $mobile,
			 					 $businessType,
			 					 $timezone,
			 					 $website,
			 					 $number_hits,
			 					 $company,
			 					 $company_contact,
			 					 $fullname_webmaster,
			 					 $email_webmaster,
			 					 ));
			 					 	
	}
} 