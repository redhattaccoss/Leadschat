<?php 
class Chat_Session extends BaseModel{
	public function  init(){
		parent::init();
		$this->_table = "chat_sessions";
	}
	public function getChatSessionCount($agent_id, $today=true){
		$db = $this->db;
		$date = date("Y-m-d");
		$sql = $db->select()->from($this->_table, array("COUNT(*) AS count"))
				->where("chat_sessions.agent_id = ?", $agent_id)
				->where("chat_sessions.active = ?", "Y");
		if ($today){
			$sql = $sql->where("DATE(chat_sessions.created) = ?", $date);
		}
		return  $db->fetchOne($sql);
	}
}
