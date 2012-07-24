<?php
class App_Member extends AppModel{
	protected $_name = "members";
	protected $_primary = "member_id";
	
	
	public function loadMembers($owner_id){
		$select = $this->select();
		$members = $this->fetchAll($select->from($this->_name, array("first_name", "last_name", "username", "owner_id", "date_created", "position", "online"))
							->where("owner_id = ?", $owner_id)
							->where("deleted = 0"))
							->group("online")->toArray();
		return $members;
	}
}