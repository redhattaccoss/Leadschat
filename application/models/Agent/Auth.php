<?php 
class Agent_Auth extends BaseModel implements Authentication{
	public function authenticate(){
		$session = new Zend_Session_Namespace("LeadsChat_Auth");
		$username = $this->_request->getPost("username");
		$password = $this->_request->getPost("password");
		$db = $this->db;
		$sql = $db->select()->from("agents")
					->where("username = ?",$username)
					->where("password = ?", md5($password))
					->where("active = 'Y'");
		$admin = $db->fetchRow($sql);
		if ($admin){
			$session->agent_id = $admin["agent_id"];
			$session->agent = $admin;
			//look for available agent availability
			$available_agent = $db->fetchRow($db->select()->from("available_agents", array("available_agent_id"))->where("agent_id = ?", $session->agent_id));
			if ($available_agent){
				$db->update("available_agents", array("available"=>"Y", "currently_served"=>0, "updated"=>date("Y-m-d h:i:s")));		
			}else{
				$db->insert("available_agents", array("available"=>"Y", "currently_served"=>0, "updated"=>date("Y-m-d h:i:s"), "agent_id"=>$admin["agent_id"]));			
			}
			return true;
		}else{
			return false;
		}
	}
	
	public function isAuthenticated(){
		$session = new Zend_Session_Namespace("LeadsChat_Auth");
		return $session->agent_id;
	}
	
	public function logout(){
		$session = new Zend_Session_Namespace("LeadsChat_Auth");
		//echo $session->agent_id;
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