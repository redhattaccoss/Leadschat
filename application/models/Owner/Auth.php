<?php 	
class Owner_Auth extends AuthenticationModel implements Authentication{
	public function authenticate(){
		$session = new Zend_Session_Namespace("LeadsChat_Owner_Auth");
		$username = $this->_request->getPost("username");
		$password = $this->_request->getPost("password");
		$rememberMe = $this->_request->getPost("remember_me");
		try{
			$this->_auth
					->setTableName("owners")
					->setIdentity($username)
					->setCredential($password)
					->setCredentialTreatment("MD5(?) AND activated = 'Y' AND approved = 'Y'");
				
			$authResult = $this->_auth->authenticate();		
			if ($authResult->isValid()){
				$owner = $this->_auth->getResultRowObject(null, "password");
				$owner = Converter::object_to_array($owner);
				$session->owner_id = $owner["owner_id"];
				$session->owner = $owner;
				if ($rememberMe){
					$cookie = new Zend_Http_Cookie("userid", $sessionAgent->owner_id, $_SERVER["SERVER_NAME"]); 
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
		$session = new Zend_Session_Namespace("LeadsChat_Owner_Auth");
		return $session->owner_id!=null;
	}
	
	public function logout(){
		$session = new Zend_Session_Namespace("LeadsChat_Owner_Auth");
		$session->unsetAll();
	}
	
	
}