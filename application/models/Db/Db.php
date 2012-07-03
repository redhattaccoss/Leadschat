<?php 
class Db_Db{
	/**
	 * Returns a connection object ...
	 * @return Zend_Db_Adapter_Pdo_Mysql
	 */
	public function conn(){
		
		/*
		$connParams = array("host" => "localhost",
		"username" => "mjames99_lchats",
		"password" => "3NYAxSkljpJV",
		"dbname" => "mjames99_testleadschat");
		*/
		$connParams = array("host" => "localhost",
						"username" => "root",
						"password" => "slasherpix01",
						"dbname" => "leadschat");
		
		$db = new Zend_Db_Adapter_Pdo_Mysql($connParams);
		return $db;
		
	}
	
	public static function getConnectionParameters(){
		return array("host" => "localhost",
						"username" => "root",
						"password" => "slasherpix01",
						"dbname" => "leadschat");
		
		/*return array("host" => "localhost",
						"username" => "mjames99_lchats",
						"password" => "3NYAxSkljpJV",
						"dbname" => "mjames99_testleadschat");
		*/
		
	}

}

