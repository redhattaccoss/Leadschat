<?php 
class Lead_InfoForm extends Zend_Form{
	
	public function init(){
		
		$db = new Db_Db();
		$dbConn = $db->conn();
		$this->setAction("processLeadsSave");
		$this->setMethod("post");
		$this->setDescription("Leads Save Form");
		$this->setAttrib("id", "leads-save-form");
		
		$this->addElement("text", "service_needed");
		$serviceNeededElement = $this->getElement("service_needed");
		$serviceNeededElement->setAttrib("placeholder", "Service Needed");
		$serviceNeededElement->setAttrib("required", "required");
		$serviceNeededElement->setLabel("Service Needed");
		
		$this->addElement("text", "service_required");
		$serviceRequiredElement = $this->getElement("service_required");
		$serviceRequiredElement->setAttrib("placeholder", "Service Required");
		$serviceRequiredElement->setAttrib("required", "required");
		$serviceRequiredElement->setLabel("Service Required");
		
		
		$this->addElement("text", "name");
		$nameElement = $this->getElement("name");
		$nameElement->setAttrib("placeholder", "Name");
		$nameElement->setAttrib("required", "required");
		$nameElement->setLabel("Name");
		
		
		$this->addElement("text", "email");
		$emailElement = $this->getElement("email");
		$emailElement->setAttrib("placeholder", "Email");
		$emailElement->setAttrib("required", "required");
		$emailElement->setLabel("Email");
		
		$this->addElement("textarea", "address1");
		$address1Element = $this->getElement("address1");
		$address1Element->setLabel("Address 1");
		$address1Element->setAttribs(array("cols"=>38, "rows"=>4));
		$this->addElement("text", "city");
		
		$cityElement = $this->getElement("city");
		$cityElement->setAttrib("placeholder", "City");
		$cityElement->setAttrib("required", "required");
		$cityElement->setLabel("City");
		$options =  array(""=>"Please select");
		$countries = $dbConn->fetchAll($dbConn->select()->from("countries", array("country_id AS id", "printable_name"))->where("country_id <> ''")->order("printable_name"));
		foreach($countries as $country){
			$options[$country["id"]] = $country["printable_name"];
		}
		$this->addElement("select", "country_id");
		$countryElement = $this->getElement("country_id");
		$countryElement->addMultiOptions($options);
		$countryElement->setLabel("Country");
		$this->addElement("text", "mobile_number");
		$mobileNumberElement = $this->getElement("mobile_number");
		$mobileNumberElement->setLabel("Mobile Number");
		$this->addElement("text", "phone_number");
		$phoneNumberElement = $this->getElement("phone_number");
		$phoneNumberElement->setLabel("Phone Number");

		$this->addElement("textarea", "notes");
		$notesElement = $this->getElement("notes");
		$notesElement->setLabel("Notes");
		$notesElement->setAttrib("cols", 38);
		$notesElement->setAttrib("rows", 4);
		
		$this->addDisplayGroup(array("service_needed", "service_required"), "leads_information");
		$this->addDisplayGroup(array("name", "email", "address1", "city", "state", "country_id", "mobile_number", "phone_number"), "visitor");
		$this->addDisplayGroup(array("notes"), "notes");		
	}
}