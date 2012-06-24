<?php
class App_ChatRequest extends AppModel{
	protected $_name = "chat_requests";
	protected $_primary = "chat_request_id";
	
	protected $chatSessionModel;
	
	public function getChatRequestForCaching($chat_request_id){
		$this->chatSessionModel = new App_ChatSession();
		if ($chat_request_id){
			$chat_request = $this->fetchRow($this->select()->where("chat_request_id = ?", $chat_request_id))->toArray();
			$chat_request["chat_session"] = $this->chatSessionModel->getAllChatSession($chat_request_id);
			return $chat_request;	
		}else{
			return null;
		}
	}
}
