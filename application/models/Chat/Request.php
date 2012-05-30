<?php
class Chat_Request extends BaseModel{
	
	public function init(){
		parent::init();
		$this->_table = "chat_requests";
	}
	public function getRequestCountForAgent($agent_id){
		$db = $this->db;
		$date = date("Y-m-d");
		$sql = $db->select()->from($this->_table, array("COUNT(*) AS count"))
				->joinInner("available_agents", "available_agents.available_agent_id = chat_requests.available_agent_id")		
				->where("available_agents.agent_id = ?", $agent_id)
				->where("DATE(chat_requests.date_created) = ?", $date)
				->where("chat_requests.accepted = 'Y'");
		return $db->fetchRow($sql);		
	}
	
	public function isAccepted($requestId){
		$db = $this->db;
		$sql = $db->select()->from($this->_table, array("accepted"))->where("chat_request_id = ?", $requestId);
		$request = $db->fetchRow($sql);
		return (!empty($request))&&($request["accepted"]=='Y');	
	}
}

