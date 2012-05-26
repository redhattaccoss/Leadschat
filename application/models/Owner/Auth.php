<?php 
class Owner_Auth extends BaseModel implements Authentication{
	public function authenticate(){
		$session = new Zend_Session_Namespace("LeadsChat_Owner_Auth");
		$username = $this->_request->getPost("username");
		$password = $this->_request->getPost("password");
		$db = $this->db;
		$sql = $db->select()->from("owners")
					->where("username = ?",$username)
					->where("password = ?", md5($password))
					->where("active = 'Y'");
		$owner = $db->fetchRow($sql);
		if ($admin){
			$session->owner_id = $owner["owner_id"];
			$session->owner = $owner;
			//look for available agent availability
			return true;
		}else{
			return false;
		}
	}
	
	public function isAuthenticated(){
		$session = new Zend_Session_Namespace("LeadsChat_Owner_Auth");
		return $session->owner_id;
	}
	
	public function logout(){
		$session = new Zend_Session_Namespace("LeadsChat_Owner_Auth");
		$session->__unset("owner_id");
		$session->__unset("owner");
	}
	
	
}