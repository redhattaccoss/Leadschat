<?php
class Mongo_Utility{
	/**
	 * 
	 * 
	 * Sample Usage
	 * $start = strtotime("2012-03-01 00:00:00");
	 * $end = strtotime("2012-03-15 00:00:00");
	 * $collection->find(array('_id' => array('$gt' => timeToId($start), '$lte' => timeToId($end))));
	 * 
	 * 
	 * @param unknown_type $ts
	 * @return MongoId
	 * @sample 
	 */
	
	public static function timeToId($ts) {
		// turn it into hex
		$hexTs = dechex($ts);
		// pad it out to 8 chars
		$hexTs = str_pad($hexTs, 8, "0", STR_PAD_LEFT);
		// make an _id from it
		return new MongoId($hexTs."0000000000000000");
	}
	
}