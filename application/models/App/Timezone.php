<?php 
class App_Timezone extends AppModel{
	protected $_primary = "timezone_id";
	protected $_name = "timezones";
	
	
	public function fetchByTimezoneGroup($timezone_group_id, $convert=false){
		$select = $this->select();
		$select->where("timezone_group_id = ?", $timezone_group_id)->order(array("name ASC"));
		/**
		 * @var Zend_Db_Table_Rowset
		 */
		$rows = $this->fetchAll($select);
		if ($convert){
			return $rows->toArray();
		}else{
			return $rows;
		}
	}
}