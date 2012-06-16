<?php
class Owner_Registration extends Zend_Form{
	public function init(){
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
		$website = new Zend_Form_Element_Text("website");
		$website->setRequired(true);
		$website->setLabel("Website");
		$website->addValidators(array(
		array("validator"=>"NotEmpty",
				  "breakChainOnFailure"=>true)),
		array("validator"=>"alnum",
				  "options"=>array("allowWhiteSpace"=>false)),
		array("validator"=>"stringLength",
				"options"=>array(13, 255))			
		);

		$username = new Zend_Form_Element_Text("username");
		$username->setRequired(true);
		$username->setLabel("Username");
		$username->addValidators(array(
		array("validator"=>"NotEmpty",
				  "breakChainOnFailure"=>true)),
		array("validator"=>"alpha",
				  "options"=>array("allowWhiteSpace"=>false)),
		array("validator"=>"stringLength",
				"options"=>array(6, 30))			
		);

		$password = new Zend_Form_Element_Password("password");
		$password->setRequired(true);
		$password->setLabel("Password");
		$password->addValidators(array(
		array("validator"=>"NotEmpty",
				  "breakChainOnFailure"=>true)),
		array("validator"=>"alnum",
				  "options"=>array("allowWhiteSpace"=>false)),
		array("validator"=>"stringLength",
				"options"=>array(6, 30))			
		);

		$confirm_password = new Zend_Form_Element_Password("confirm_password");
		$confirm_password->setLabel("Confirm Password");
		$confirm_password->setRequired(true);
		$confirm_password->addValidators(array(
		array("validator"=>"NotEmpty",
				  "breakChainOnFailure"=>true)),
		array("validator"=>"alnum",
				  "options"=>array("allowWhiteSpace"=>false)),
		array("validator"=>"stringLength",
				"options"=>array(6, 30))			
		);


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

		$mobile = new Zend_Form_Element_Text("mobile");
		$mobile->setLabel("Contact <span class=\"help\">(Skype, Mobile)</span>");
		$mobile->setRequired(true);
		$mobile->addValidators(array(
		array("validator"=>"NotEmpty",
				  "breakChainOnFailure"=>true)),
		array("validator"=>"stringLength",
				"options"=>array(10, 20))			
		);
		$mobile->getDecorator("Label")->setOption("escape", false);
		$fullname_webmaster = new Zend_Form_Element_Text("fullname_webmaster");
		$fullname_webmaster->setLabel("Name <span class='help'>(Company's Web Designer)</span>");
		$fullname_webmaster->addValidators(array(
		array("validator"=>"stringLength",
					"options"=>array(0, 100))			
		)
			
		);
		$fullname_webmaster->getDecorator("Label")->setOption("escape", false);
		$email_webmaster = new Zend_Form_Element_Text("email_webmaster");
		$email_webmaster->setLabel("Email Address");
		$email_webmaster->addValidators(array(
		array("validator"=>"emailAddress"),
		array("validator"=>"stringLength",
				"options"=>array(0, 50))			
		));

		$phone_webmaster = new Zend_Form_Element_Text("phone_webmaster");
		$phone_webmaster->setLabel("Phone Number");
		$phone_webmaster->addValidators(
		array(array("validator"=>"stringLength",
				"options"=>array(0, 20)))			
		);
		$company = new Zend_Form_Element_Text("company");
		$company->setLabel("Company");
		$company->addValidators(array(array("validator"=>"stringLength", "options"=>array(0, 20))));
		$items = array();
		$items[""] = "Please Select";
		$numberOfHitModel = new App_NumberOfHit();
		$hits = $numberOfHitModel->fetchAll()->toArray();
		foreach($hits as $hit){
			$items[$hit["id"]] = $hit["name"];
		}

		$number_hits = new Zend_Form_Element_Select("number_of_hit_id");
		$number_hits->setRequired(true);
		$number_hits->setLabel("How many web hits do you currently receive each month?");
		$number_hits->addMultiOptions($items);



		$businessType = new Zend_Form_Element_Text("business_type");
		$businessType->setRequired(true);
		$businessType->setLabel("Business Type");

		$timezoneGroupModel = new App_TimezoneGroup();
		$timezoneGroups = $timezoneGroupModel->getAllTimezonesGrouped();
		$items = array();
		$items[""] = "Please Select";
		foreach($timezoneGroups as $timezoneGroup){
			$timezones = $timezoneGroup["timezones"];
			foreach($timezones as $timezone){
				$items[$timezoneGroup["name"]][$timezone["timezone_id"]]=$timezone["name"];
			}
		}
		$timezone = new Zend_Form_Element_Select("timezone_id");
		$timezone->setRequired(true);
		$timezone->setLabel("What time zone is your business located?");
		$timezone->addMultiOptions($items);


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