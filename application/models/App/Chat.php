<?php
class App_Chat extends AppModel{
	protected $_name = "chats";
	protected $_primary = "chat_id";
	
	public function getAllChatFromSession($chat_session_id){
		$select = $this->select();
		if ($chat_session_id){	
			$chats = $this->fetchAll($select->where("chat_session_id = ?", $chat_session_id))->toArray();
			foreach($chats as $key=>$chat){
				$chats[$key]["chat_start"] = new MongoDate(strtotime($chat["chat_start"]));
				$chats[$key]["chat_end"] = new MongoDate(strtotime($chat["chat_end"]));
				$chats[$key]["created"] = new MongoDate(strtotime($chat["created"]));
			}	
			return $chats;
		}else{
			return null;
		}	
	}
}
