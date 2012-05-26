<?php 
class Agent_Login extends Zend_Form{
	public function init(){
		$this->setAction("processLogin");
		$this->setMethod("post");
		$this->setDescription("Agent Login");
		$this->setAttrib("id", "login-form");
		
		$this->addElement("text", "username");
		$usernameElement = $this->getElement("username");
		$usernameElement->setAttrib("placeholder", "Username");
		$usernameElement->setAttrib("required", "required");
		
		$this->addElement("password", "password");
		$passwordElement = $this->getElement("password");
		$passwordElement->setAttrib("placeholder", "Password");
		$passwordElement->setAttrib("required", "required");
		
		$this->addElement("button", "login");
		$loginButton = $this->getElement("login");
		$loginButton->setLabel("Login");
		$loginButton->setAttrib("id", "loginButton");
		$loginButton->setAttrib("type", "submit");
				
	}
}
