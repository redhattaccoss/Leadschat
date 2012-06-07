<?php 
class App_TimezoneGroup extends AppModel{
	protected $_name = "timezone_groups";
	protected $_primary = "id";
	
	public function getAllTimezonesGrouped(){
		/**
		 * @var Zend_Db_Table_Rowset
		 */
		$timezoneGroups = $this->fetchAll();
		$timezoneGroups = $timezoneGroups->toArray();
		$timezone = new App_Timezone();
		foreach($timezoneGroups as $key=>$timezoneGroup){
			$timezoneGroups[$key]["timezones"] = $timezone->fetchByTimezoneGroup($timezoneGroup["id"]);
		}
		return $timezoneGroups;
	}
}