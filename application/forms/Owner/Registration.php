<?php 
class Owner_Registration extends Zend_Form{
	public function init(){
		$this->addDecorators(array("ViewHelper"), array("Errors"));
		$firstname = new Zend_Form_Element_Text("first_name");
		$firstname->setLabel("Firstname");
		$firstname->setRequired(true);
		$lastname = new Zend_Form_Element_Text("last_name");
		$lastname->setLabel("Lastname");
		$lastname->setRequired(true);
		$website = new Zend_Form_Element_Text("website");
		$website->setRequired(true);
		$website->setLabel("Website");
		$username = new Zend_Form_Element_Text("username");
		$username->setRequired(true);
		$username->setLabel("Username");
		$password = new Zend_Form_Element_Password("password");
		$password->setRequired(true);
		$password->setLabel("Password");
		$confirm_password = new Zend_Form_Element_Password("confirm_password");
		$confirm_password->setLabel("Confirm Password");
		$confirm_password->setRequired(true);
		$email = new Zend_Form_Element_Text("email");
		$email->setLabel("Email Address");
		$email->setRequired(true);
		$mobile = new Zend_Form_Element_Text("mobile");
		$mobile->setLabel("Contact <span class=\"help\">(Skype, Mobile)</span>");
		$mobile->setRequired(true);
		$mobile->getDecorator("Label")->setOption("escape", false);
		$fullname_webmaster = new Zend_Form_Element_Text("fullname_webmaster");
		$fullname_webmaster->setLabel("Name <span class='help'>(Company's Web Designer)</span>");
		$fullname_webmaster->getDecorator("Label")->setOption("escape", false);
		$email_webmaster = new Zend_Form_Element_Text("email_webmaster");
		$email_webmaster->setLabel("Email Address");
		$phone_webmaster = new Zend_Form_Element_Text("phone_webmaster");
		$phone_webmaster->setLabel("Phone Number");
		$company = new Zend_Form_Element_Text("company");
		$company->setLabel("Company");
		$number_hits = new Zend_Form_Element_Select("number_of_hit_id");
		$number_hits->setRequired(true);
		$number_hits->setLabel("How many web hits do you currently receive each month?");
		$businessType = new Zend_Form_Element_Select("business_type");
		$businessType->setRequired(true);
		$businessType->setLabel("Business Type");
		$timezone = new Zend_Form_Element_Select("timezone_id");
		$timezone->setRequired(true);
		$timezone->setLabel("What time zone is your business located?");
		$accept = new Zend_Form_Element_Checkbox("accept");
		$accept->setLabel("I Accept, the Terms and Service");
		$accept->setRequired(true);
		$accept->setDecorators(array('ViewHelper'));
		
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
			 					 $fullname_webmaster,
			 					 $email_webmaster,
			 					 $phone_webmaster,
			 					 $accept
			 					 ));
	}
} 