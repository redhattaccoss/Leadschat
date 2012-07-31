<?php
class Mongo_Logs_LogoutOwner implements Mongo_Logs_Log{
	public function getLog($data){
		$result = array();
		$result["importance"] = Mongo_Logs_Log::SYSTEM_LOG;
		$result["action"] = "LOGOUT";
		$result["done_by"] = "OWNER";
		$result["date_created"] = new MongoDate(strtotime(date("Y-m-d h:i:s")));
		$result["details"] = $data;
		return $result;
	}
}