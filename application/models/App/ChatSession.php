<?php
class App_ChatSession extends AppModel{
	protected $_name = "chat_sessions";
	protected $_primary = "chat_session_id";
	
	protected $chatModel;
	
	public function getAllChatSession($chat_request_id){
		$this->chatModel = new App_Chat();
		$select = $this->select();
		if ($chat_request_id){
			$chat_session = $this->fetchRow($select->where("chat_request_id = ?", $chat_request_id))->toArray();
			$chat_session["chats"] = $this->chatModel->getAllChatFromSession($session["chat_session_id"]);
			return $chat_session;			
		}else{
			return null;
		}

	}
}
