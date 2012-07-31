<?php
class Mongo_Logger{
	
	public static function logEvent($data, $logType, $collectionName){
		try{
			$mongo = Db_Mongo::instantiate();
			$collection = $mongo->getCollection($collectionName);
			$log = Mongo_Logs_LogFactory::getLog($logType);
			$data = $log->getLog($data);
			$collection->insert($data);
			return true;
		}catch(Exception $e){
			return false;		
		}
		
	}
}