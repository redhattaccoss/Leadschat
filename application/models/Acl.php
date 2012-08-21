<?php 
class Acl extends Zend_Acl{
	const ROLE_GUEST = "guest";
	const ROLE_OWNER = "owner";
	const ROLE_MEMBER = "member";
	const ROLE_AGENT = "agent";
	const ROLE_ADMIN = "admin";
	
	protected static $instance;
	
	public function __construct(){
		$this->addRole(new Zend_Acl_Role(self::ROLE_GUEST));
		$this->addRole(new Zend_Acl_Role(self::ROLE_MEMBER), self::ROLE_GUEST);
		$this->addRole(new Zend_Acl_Role(self::ROLE_OWNER), self::ROLE_MEMBER);
		$this->addRole(new Zend_Acl_Role(self::ROLE_AGENT));
		$this->addRole(new Zend_Acl_Role(self::ROLE_ADMIN), self::ROLE_AGENT);
	
		
		$controllers  = array("agents", "chats", "index", "leads", "owners", "qa", "admin", "number-of-hits", "timezones", "countries", "call-center");
		//define ROLE GUEST
		foreach($controllers as $controller){
			$this->addResource(new Zend_Acl_Resource($controller));
		}
		
		$this->allow(self::ROLE_GUEST, null, array("register", "login", "process-register", "process-login", "cache", "forgotpassword", "register-complete"));
		
		$this->allow(self::ROLE_GUEST, "index", array("index", "about", "contact", "pricing", "how-it-works", "why", "benefits-livechat"));
		$this->allow(self::ROLE_GUEST, "owners", array("username-existing", "get"));
		$this->deny(self::ROLE_GUEST, "owners", array("index"));
		$this->allow(self::ROLE_MEMBER, "owners", array("index"));
		$this->allow(self::ROLE_AGENT, "agents", array("index", "dashboard"));
		$this->allow(self::ROLE_ADMIN);		
	}
	
}
