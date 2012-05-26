<?php

class LeadsController extends BaseLeadController
{
    
	public function saveAndSendAction(){
		$this->saveLead(1);
	}
	
	private function saveLead($sent=1){
		$db = $this->db;
		if ($this->_request->isXMLHttpRequest()){
			$request = $this->_request;
			
			//visitors information
			$visitor_id = $request->getPost("visitor_id");
			$name = $request->getPost("name");
			$email = $request->getPost("email");
			$address1 = $request->getPost("address1");
			$city = $request->getPost("city");
			$state = $request->getPost("state");
			$country_id = $request->getPost("country_id");
			$mobile_number = $request->getPost("mobile_number");
			$phone_number = $request->getPost("phone_number");
			$company = $request->getPost("company");
			
			$visitor = array("name"=>$name, 
							 "email"=>$email,
							 "address1"=>$address1,
							 "city"=>$city,
							 "state"=>$state,
							 "country_id"=>$country_id,
							"mobile_number"=>$mobile_number, 
							"phone_number"=>$phone_number,
							"company"=>$company);
			
			$db->update("visitors", $visitor, "visitor_id = {$visitor_id}");
			
			$sql = $db->select()->from("visitors", array("owner_id"))->where("visitor_id = ?", $visitor_id);
			$visitor = $db->fetchRow($sql);
			
			//leads information
			$lead_id = $request->getPost("lead_id");
			$service_needed = $request->getPost("service_needed");
			$service_required = $request->getPost("service_required");
			$notes = $request->getPost("notes");
			$date = date("Y-m-d h:i:s");
			$ended = 1;
			$chat_end = $date;
			$sent = $sent;
			$lead = array("service_needed"=>$service_needed,
						  "service_required"=>$service_required,
						  "notes"=>$notes,
						  "updated"=>$date,
						  "ended"=>$ended,
						  "chat_end"=>$chat_end,
			      		  "sent"=>$sent,
					      "owner_id"=>$visitor["owner_id"]);
			$db->update("leads", $lead, "lead_id = {$lead_id}");
		}		
	}
	
	public function saveAction(){
		$this->saveLead(0);
	}
	


	
		
	
}

