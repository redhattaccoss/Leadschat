<?php
class Mongo_Logs_LogFactory{
	
	const LoginOwner = "LoginOwner";
	const LogoutOwer = "LogoutOwner";
	
	/**
	 * @param string $name Name of the Log
	 * @return Mongo_Logs_Log
	 */
	public static function getLog($name){
		$name = "Mongo_Logs_".$name;
		return new $name();
	}
}