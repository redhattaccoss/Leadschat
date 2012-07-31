<?php

class LeadsController extends AppController
{
	/**
	 * @var App_Lead
	 */
	private $leadModel;
	
	/**
	 * @var App_Owner
	 */
	private $ownerModel;
	public function init(){
		$this->leadModel = new App_Lead();
		$this->ownerModel = new App_Owner();
		parent::init();
	}
    
	public function saveAndSendAction(){
		$this->saveLead(1);
	}
	
	public function processApproveAction(){
		if ($this->getRequest()->isXmlHttpRequest()){
			$lead_id = $this->getRequest()->getPost("lead_id");
			if ($lead_id){
				$lead = $this->leadModel->find($lead_id)->toArray();
				if ($lead){
					$owner_id = $lead["owner_id"];
					if ($this->ownerModel->hasSufficientCredit($owner_id)&&$this->ownerModel->isBulkSubscriber($owner_id)){
						$this->leadModel->approve($lead_id);
					}else{
						$this->view->result = array("success"=>false, "error"=>"Has no sufficient credit");
					}
				}
			}else{
				$this->view->result = $this->_invalidRequest();
			}
		}else{
			$this->view->result = $this->_invalidRequest();
		}
		$this->_helper->layout->setLayout("plain");
		$this->_helper->viewRenderer("json");
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
			$lead = array("service_needed"=>$service_needed,
						  "service_required"=>$service_required,
						  "notes"=>$notes,
						  "updated"=>$date,
						  "ended"=>$ended,
						  "chat_end"=>$chat_end,
			      		  "sent"=>$sent,
					      "owner_id"=>$visitor["owner_id"]);
			$db->update("leads", $lead, "lead_id = {$lead_id}");
			
			$leadModel = new App_Lead();
			$leadModel->cacheLead($lead_id);		
		}		
	}
	
	public function getLeadsOfOwnerAction(){
		$owner_id =$this->_request->getQuery("owner_id");
		if ($owner_id){
			$leads = $this->leadModel->getAll($owner_id);
			$this->view->result = array("success"=>true, "leads"=>$leads);
		}else{
			$this->view->result = $this->_invalidRequest();
		}
	}
	
	
	public function cacheAction(){
		$lead_id = $this->_request->getQuery("lead_id");
		if ($lead_id){
			if ($this->leadModel->cacheLead($lead_id)){
				$this->view->result = array("success"=>true);
			}else{
				$this->view->result = array("success"=>false);
			}
		}
		
		$this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");
	}
	
	
	public function saveAction(){
		$this->saveLead(0);
	}
}

