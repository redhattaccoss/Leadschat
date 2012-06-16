<?php
abstract class AuthenticationModel extends BaseModel{
	protected $_auth;
	public function __construct(){
		$this->db = Zend_Registry::get("main_db");
		$this->_auth = new Zend_Auth_Adapter_DbTable($db);
		$this->_auth->setIdentityColumn("username")->setCredentialColumn("password");
	}
}