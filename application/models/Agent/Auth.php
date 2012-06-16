<?php 
class Agent_Auth extends AuthenticationModel implements Authentication{
	public function authenticate(){
		$db = $this->db;
		$session = new Zend_Session_Namespace("LeadsChat_Auth");		
		$username = $this->_request->getPost("username");
		$password = $this->_request->getPost("password");
		
		
		//authenticate using Zend Auth
		try{
			$this->_auth->setTableName("agents");
			$this->_auth->setCredentialTreatment("MD5(?) AND active = 'Y'");
			$authResult = $this->_auth->setCredential($password)
									->setIdentity($username)
									->authenticate();
			
			$agent = $this->_auth->getResultRowObject(null, "password");
			$agent = Converter::object_to_array($agent);
			if ($agent){
				$session->agent_id = $agent["agent_id"];
				$session->agent = $agent;
				//look for available agent availability
				$available_agent = $db->fetchRow($db->select()->from("available_agents", array("available_agent_id"))->where("agent_id = ?", $session->agent_id));
				if ($available_agent){
					$db->update("available_agents", array("available"=>"Y", "currently_served"=>0, "updated"=>date("Y-m-d h:i:s")));		
				}else{
					$db->insert("available_agents", array("available"=>"Y", "currently_served"=>0, "updated"=>date("Y-m-d h:i:s"), "agent_id"=>$agent["agent_id"]));			
				}
				return true;
			}else{
				return false;
			}
		}catch(Exception $e){
			return false;	
		}		
		
		
	}
	
	public function isAuthenticated(){
		$session = new Zend_Session_Namespace("LeadsChat_Auth");
		return $session->agent_id;
	}
	
	public function logout(){
		$session = new Zend_Session_Namespace("LeadsChat_Auth");
		$db = $this->db;
		$db->update("available_agents", array("currently_served"=>0), "agent_id = {$session->agent_id}");		
		$db->update("available_agents", array("available"=>"N"), "agent_id = {$session->agent_id}");
		$session->__unset("agent_id");
		$session->__unset("agent");
		$session->__unset("chat_sessions");
		
	}
	
	public function getUser(){
		$session = new Zend_Session_Namespace("LeadsChat_Auth");
		return $session->agent;
	}

}