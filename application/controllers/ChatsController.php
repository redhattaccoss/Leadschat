<?php
class ChatsController extends AppController
{

	public function chatAction(){
		$db = $this->db;
		$sessionVisitor = new Zend_Session_Namespace("LeadsChat_Visitor");
		$sessionId = session_id();
		if (!$this->ipChecker->isIpBlocked()){
			$this->view->ipBlocked = false;
			$website = $this->_request->getQuery("website");
			$this->view->website = $website;
			$sql = $db->select()->from("owners", array("owner_id"))->where("website = ?", $website);
			$owner = $db->fetchRow($sql);
			if ($owner){
				if ($sessionVisitor->visitor_id){
					//check visitor if already has been recorded on database
					$sql = $db->select()->from("visitors")->where("visitor_id = ?", $sessionVisitor->visitor_id);
					$visitor = $db->fetchRow($sql);
					if ($visitor){
						$this->view->visitor_id = $visitor["visitor_id"];
						$visitor = array(
		        							"session_id"=>$sessionId, 
		        							"ip_address"=>ip2long($_SERVER["REMOTE_ADDR"]),
											"owner_id"=>$owner["owner_id"],
											"ip"=>$_SERVER["REMOTE_ADDR"]);
						$db->update("visitors", $visitor, "visitors.visitor_id = {$this->view->visitor_id}");
					}else{
						//create a visitor object
						$visitor = array(
		        							"session_id"=>$sessionId, 
		        							"ip_address"=>ip2long($_SERVER["REMOTE_ADDR"]),
											"owner_id"=>$owner["owner_id"],
											"ip"=>$_SERVER["REMOTE_ADDR"]
						);
						$db->insert("visitors", $visitor);
						$this->view->visitor_id = $sessionVisitor->visitor_id;
						$sessionVisitor->visitor_id = $this->view->visitor_id;
						 
					}
				}else{
					//create a visitor object
					$visitor = array(
	        							"session_id"=>$sessionId, 
	        							"ip_address"=>ip2long($_SERVER["REMOTE_ADDR"]),
										"owner_id"=>$owner["owner_id"],
										"ip"=>$_SERVER["REMOTE_ADDR"]
					);
					$db->insert("visitors", $visitor);
					$this->view->visitor_id = $db->lastInsertId("visitors");
					$sessionVisitor->visitor_id = $this->view->visitor_id;
				}
				$this->view->headTitle("Leads Chat");
				$this->view->headScript()->appendFile($this->baseUrl."/js/jquery.js", "text/javascript");
				$this->view->headScript()->appendFile($this->baseUrl."/js/chat.js", "text/javascript");
				$this->view->headLink()->appendStylesheet($this->baseUrl."/css/chatplugin.css");
			}
		}else{
			$this->_helper->viewRenderer("ipblocked");
		}
	}

	public function getAcceptedRequestAction(){
		$db = $this->db;
		$sessionVisitor = new Zend_Session_Namespace("LeadsChat_Visitor");
		if ($this->_request->isXmlHttpRequest()){
			$visitor_id = $this->_request->getPost("visitor_id");
			if ($visitor_id){
				$sql = $db->select()->from("chat_requests")->
				where("visitor_id = ?", $visitor_id)
				->where("accepted = 'Y'")->order("date_created");
				$request = $db->fetchRow($sql);
				if ($request){
					//get associated chat session
					$chat_session = $db->fetchRow($db->select()->from("chat_sessions", array("chat_session_id"))->where("chat_request_id = ?", $request["chat_request_id"]));
					$sessionVisitor->chat_session = $chat_session;
					$this->view->result = array("success"=>true, "request"=>$request, "chat_session"=>$chat_session);
				}else{
					$this->view->result = array("success"=>false);
				}
				 
			}
		}else{
			$this->view->result = array("success"=>false);
		}
		$this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json"); 
		
	}


	public function loadChatAction(){
		$db = $this->db;
		if ($this->_request->isXmlHttpRequest()){
			$chat_session_id = $this->_request->getPost("chat_session_id");
			$sql = $db->select()
			->from("chats")
			->where("chat_session_id = ?", $chat_session_id)
			->order("created ASC");
			$chats = $db->fetchAll($sql);
			$sql = $db->select()->from("chat_sessions", array())
				->joinInner("agents", "agents.agent_id = chat_sessions.agent_id")
				->where("chat_sessions.chat_session_id = ?", $chat_session_id);
			$agent = $db->fetchRow($sql);
			$i=0;
			foreach($chats as $chat){
				$chats[$i]["formatted_time"] = date("h:i", strtotime($chat["created"]));
				$i++;
			}
			$this->view->result = array("success"=>true, "chats"=>$chats, "agent"=>$agent);
		}else{
			$this->view->result = array("success"=>false);
		}
		$this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json"); 
	}

	public function initializeAction(){
		$db = $this->db;
		if ($this->_request->isXmlHttpRequest()){
			$visitor_id = $this->_request->getQuery("visitor_id");
			$website = $this->_request->getQuery("website");
			if ($visitor_id){
				//delete beforehand visitors' chat requests
				$db->delete("chat_requests", "visitor_id = $visitor_id");
				$sql = $db->select()->from("available_agents", array("available_agent_id"))
				->joinRight("agents_owners", "agents_owners.agent_id = available_agents.agent_id", array())
				->joinInner("owners", "owners.owner_id = agents_owners.owner_id", array())
				->where("owners.website = ?", $website)
				->where("available = 'Y'")
				->group("available_agents.available_agent_id")
				->order("updated");
				$agents = $db->fetchAll($sql);
				if (!empty($agents)){
					$date = date("Y-m-d h:i:s");
					foreach($agents as $agent){
						$request = array(
    						"visitor_id"=>$visitor_id,
    						"available_agent_id"=>$agent["available_agent_id"]
						,"date_created"=>$date
						);
						$db->insert("chat_requests", $request);
					}
					$this->view->result = array("success"=>true, "count"=>count($agents));
				}else{
					$this->view->result = array("success"=>true, "count"=>0);	
				}
			}else{
				$this->view->result = array("success"=>false);
			}
		}else{
			$this->view->result = array("success"=>false);
		}
		$this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json"); 
	}


	public function sendAction(){
		$db = $this->db;
		if ($this->_request->isXmlHttpRequest()){
			$message = $this->_request->getPost("message");
			$from_id = $this->_request->getPost("from_id");
			$from_type = $this->_request->getPost("from_type");
			$chat_session_id = $this->_request->getPost("chat_session_id");
			$date = date("Y-m-d h:i:s");
			if (trim($message)!=""){
				$chat = array("from_id"=>$from_id,
    						  "from_type"=>$from_type,
    						  "chat_session_id"=>$chat_session_id,
							   "message"=>trim($message),
    						  "created"=>$date);
				$db->insert("chats", $chat);
				
				//load chat from db
				$chat_session_id = $this->_request->getPost("chat_session_id");
				$sql = $db->select()
				->from("chats")
				->where("chat_session_id = ?", $chat_session_id)
				->order("created");
				$chats = $db->fetchAll($sql);
				$i=0;
				$sql = $db->select()->from("chat_sessions", array())
					->joinInner("agents", "agents.agent_id = chat_sessions.agent_id")
					->where("chat_sessions.chat_session_id = ?", $chat_session_id);
				$agent = $db->fetchRow($sql);
				
				foreach($chats as $chat){
					$chats[$i]["formatted_time"] = date("h:i", strtotime($chat["created"]));
					$i++;
				}				
				$this->view->result = array("success"=>true, "chats"=>$chats, "agent"=>$agent);
			}else{
				$this->view->result = array("success"=>false);
			}
		}else{
			$this->view->result = array("success"=>false);	
		}
		$this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");
	}
	
	public function getVisitorSessionAction(){
		$sessionVisitor = new Zend_Session_Namespace("LeadsChat_Visitor");
		if ($this->_request->isXmlHttpRequest()){
			if ($sessionVisitor->visitor_id&&$sessionVisitor->chat_session){
				$this->view->result = array("success"=>true, "visitor_id"=>$sessionVisitor->visitor_id, "chat_session"=>$sessionVisitor->chat_session);
			}else{
				$this->view->result = array("success"=>false);
			}
		}else{
			$this->view->result = array("success"=>false);
		}
		$this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");
	}
	
	public function getSessionInfoAction(){
		$db = $this->db;
		if ($this->_request->isXmlHttpRequest()){
			$chat_session_id = $this->_request->getQuery("chat_session_id");
			$chat_session = $db->fetchRow($db->select()->from("chat_sessions")->where("chat_session_id = ?", $chat_session_id));		
			if ($chat_session){
				$agent = $db->fetchRow($db->select()->from("agents", array("agent_id", "last_name", "first_name", "picture"))->where("agent_id = ?", $chat_session["agent_id"]));
				$this->view->result = array("success"=>true, "chat_session"=>$chat_session, "agent"=>$agent);				
			}else{
				$this->view->result = array("success"=>false);
			}
		}else{
			$this->view->result = array("success"=>false);
		}
		$this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");
	}

}