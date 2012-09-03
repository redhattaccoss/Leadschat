<?php
class Owner_RegistrationStep2 extends Zend_Form{
	public function init(){
		$this->addDecorators(array("ViewHelper"), array("Errors"));
		$company = new Zend_Form_Element_Text("company");
		$company->setLabel("Company");
		$company->class = "span4";
		$company->addValidators(array(array("validator"=>"stringLength", "options"=>array(0, 20))));
		

		$businessType = new Zend_Form_Element_Text("business_type");
		$businessType->setRequired(true);
		$businessType->setLabel("Business Type");
		$businessType->class = "span4";
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
		$timezone->class = "span4";
		$timezone->addMultiOptions($items);
		

		$website = new Zend_Form_Element_Text("website");
		$website->setRequired(true);
		$website->setLabel("Website");
		$website->class = "span4";
		$website->addValidators(array(
		array("validator"=>"NotEmpty",
				  "breakChainOnFailure"=>true)),
		array("validator"=>"alnum",
				  "options"=>array("allowWhiteSpace"=>false)),
		array("validator"=>"stringLength",
				"options"=>array(13, 255))			
		);

		$items = array();
		$items[""] = "Please Select";
		$numberOfHitModel = new App_NumberOfHit();
		$hits = $numberOfHitModel->fetchAll()->toArray();
		foreach($hits as $hit){
			$items[$hit["id"]] = $hit["name"];
		}
		$number_hits = new Zend_Form_Element_Select("number_of_hit_id");
		$number_hits->setRequired(true);
		$number_hits->class = "span4";
		$number_hits->setLabel("How many web hits do you currently receive each month?");
		$number_hits->addMultiOptions($items);

		$mobile = new Zend_Form_Element_Text("mobile");
		$mobile->setLabel("Contact <span class=\"help\">(Skype, Mobile)</span>");
		$mobile->setRequired(true);
		$mobile->class = "span6";
		$mobile->addValidators(array(
		array("validator"=>"NotEmpty",
				  "breakChainOnFailure"=>true)),
		array("validator"=>"stringLength",
				"options"=>array(10, 20))			
		);
		$mobile->getDecorator("Label")->setOption("escape", false);			
		
		$address1 = new Zend_Form_Element_Text("address1");
		$address1->setLabel("Address 1");
		$address1->class = "span6";
		$address1->setRequired(true);
		$address1->addValidators(array(
		array("validator"=>"NotEmpty",
				  "breakChainOnFailure"=>true)),
		array("validator"=>"stringLength",
				"options"=>array(10, 255))			
		);
		$address2 = new Zend_Form_Element_Text("address2");
		$address2->setLabel("Address 2");
		$address2->class = "span6";
		$address2->addValidators(array(
			array("validator"=>"stringLength",
					"options"=>array(10, 255)))			
		);				
		
		$city = new Zend_Form_Element_Text("city");
		$city->setLabel("City");
		$city->class = "span4";
		$city->setRequired(true);
		$city->addValidators(array(
		array("validator"=>"NotEmpty",
				  "breakChainOnFailure"=>true)),
		array("validator"=>"stringLength",
				"options"=>array(10, 255))			
		);
		
		$postal = new Zend_Form_Element_Text("postal");
		$postal->setLabel("Postal Code");
		$postal->class = "span2";
		$postal->setRequired(true);
		$postal->addValidators(array(
		array("validator"=>"NotEmpty",
				  "breakChainOnFailure"=>true)),
		array("validator"=>"stringLength",
				"options"=>array(10, 30))			
		);
		
		$state = new Zend_Form_Element_Text("state");
		$state->setLabel("State");
		$state->class = "span4";
		$state->setRequired(true);
		$state->addValidators(array(
		array("validator"=>"NotEmpty",
				  "breakChainOnFailure"=>true)),
		array("validator"=>"stringLength",
				"options"=>array(10, 30))			
		);
		
		$items = array();
		$items[""] = "Please Select";
		$countryModel = new App_Country();		
		$countries = $countryModel->fetchAll()->toArray();
		foreach($countries as $country){
			$items[$country["id"]] = $country["name"];
		}
		$country = new Zend_Form_Element_Select("country_id");
		$country->class = "span4";
		$country->addMultiOptions($items);
		$country->setRequired(true);
		$country->setLabel("Country");

		$this->addElements(array(
			$company, 		
			$businessType, 
			$state, 
			$country,
			$postal,
			$city,
			$state,
			$address1,
			$address2,
			$mobile,
			$number_hits,
			$timezone,
			$website
		));
	}
}