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
			$chat_request["date_created"] = new MongoDate(strtotime($chat_request["date_created"]));
			return $chat_request;	
		}else{
			return null;
		}
	}
	
	
	public function listAcceptedChatRequests($agent_id, $date){
		$select = $this->select()->from($this->_name)
					->joinInner("available_agents", "available_agents.available_agent_id = chat_requests.available_agent_id", array())
					->joinInner("visitors", "chat_requests.visitor_id = visitors.visitor_id", array())
					->joinInner("owners", "visitors.owner_id = owners.owner_id", array("website"))
					->where("available_agents.agent_id = ?", $agent_id)
					->where("DATE(chat_requests.date_created = DATE(?)", $date)
					->where("chat_requests.accepted = 'Y'")
					->order("chat_requests.date_created DESC")
					->limit(4);
		return $this->fetchAll($select)->toArray();
	}

	public function listNewChatRequests($agent_id, $date){
		$select = $this->select()->from($this->_name)
		->joinInner("available_agents", "available_agents.available_agent_id = chat_requests.available_agent_id", array())
		->joinInner("visitors", "chat_requests.visitor_id = visitors.visitor_id", array())
		->joinInner("owners", "visitors.owner_id = owners.owner_id", array("website"))
		->where("available_agents.agent_id = ?", $agent_id)
		->where("DATE(chat_requests.date_created = DATE(?)", $date)
		->where("chat_requests.accepted = 'N'")
		->order("chat_requests.date_created DESC")
		->limit(4);
		return $this->fetchAll($select)->toArray();
	}
	
}
