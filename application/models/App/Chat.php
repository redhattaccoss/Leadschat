<?php
class App_Chat extends AppModel{
	protected $_name = "chats";
	protected $_primary = "chat_id";
	
	public function getAllChatFromSession($chat_session_id){
		$select = $this->select();
		if ($chat_session_id){	
			return $this->fetchAll($select->where("chat_session_id = ?", $chat_session_id))->toArray();	
		}else{
			return null;
		}	
	}
}
