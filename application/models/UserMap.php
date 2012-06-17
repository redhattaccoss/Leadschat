<?php 
class UserMap{
	/**
	 * Convinience function to get user ...
	 */
	public static function getUser(){
		$sessionAgent = new Zend_Session_Namespace("LeadsChat_Auth");
		$sessionOwner = new Zend_Session_Namespace("LeadsChat_Owner_Auth");
		
		if ($sessionAgent->agent){
			$agent = $sessionAgent->agent;
			$agent["level"] = $agent["type"];
			return $agent;
		}
		
		if ($sessionOwner->owner){
			$owner = $sessionOwner->owner;
			$owner["level"] = "Owner";
			return $owner;
		}
		return null;
	}
	
	public static function getRole(){
		$sessionAgent = new Zend_Session_Namespace("LeadsChat_Auth");
		$sessionOwner = new Zend_Session_Namespace("LeadsChat_Owner_Auth");
		if ($sessionAgent->__isset("agent")){
			$agent = $sessionAgent->agent;
			$agent["level"] = $agent["type"];
			return strtolower($agent["level"]);
		}
		
		if ($sessionOwner->__isset("owner")){
			$owner = $sessionOwner->owner;
			$owner["level"] = "Owner";
			return strtolower($owner["level"]);
		}
		return "guest";
	}
}
