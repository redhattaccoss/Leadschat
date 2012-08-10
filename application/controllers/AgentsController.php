<?php

class AgentsController extends AppController
{

	private $chatRequestModel;
	
	private $chatSessionModel;
	
	private $leadModel;
	
	private $appChatRequestModel;
	
	private $agentModel;
	
    public function init()
    {
        /* Initialize action controller here */
    	parent::init();
    	$this->auth = AuthFactory::create(AuthFactory::$AGENT, $this->db, $this->_request);
    	$this->chatRequestModel = new Chat_Request($this->db);
    	$this->chatSessionModel =  new Chat_Session($this->db);
    	$this->appChatRequestModel = new App_ChatRequest();
    	$this->leadModel = new App_Lead();
    	$this->agentModel = new App_Agent();
    }

    public function loadAcceptedChatRequestsAction(){
    	$sessionAgent = new Zend_Session_Namespace("LeadsChat_Auth");
    	if ($sessionAgent->agent_id&&$this->isXmlHttpRequest()){
    		$date = date("Y-m-d h:i:s");
    		$chat_requests = $this->appChatRequestModel->listAcceptedChatRequests($sessionAgent->agent_id, $date);
	     	$this->view->result = array("result"=>true, "rows"=>$chat_requests);   		
    	}else{
    		$this->view->result = array("result"=>false);
    	}
    	$this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");
    }
    
    public function loadChatRequestsAction(){
    	$sessionAgent = new Zend_Session_Namespace("LeadsChat_Auth");
        if ($sessionAgent->agent_id){
        	$date = date("Y-m-d h:i:s");
        	$chat_requests = $this->appChatRequestModel->listNewChatRequests($sessionAgent->agent_id, $date);
        	$this->view->result = array("result"=>true, "rows"=>$chat_requests);
        }else{ 
        	$this->view->result = array("result"=>false);
        }    	
		$this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");        
    }
    
    public function loadSessionAction(){
        $db = $this->db;
    	$sessionAgent = new Zend_Session_Namespace("LeadsChat_Auth");
        if (!$sessionAgent->__isset("chat_sessions")){
        	$sessionAgent->chat_sessions = array();
        }
        if (!$sessionAgent->__isset("current_chat_session")){
        	$sessionAgent->current_chat_session = 0;
        }
		$output = array();
		$active = array();
		foreach($sessionAgent->chat_sessions as $sessionId){
			$chat_session = $db->fetchRow($db->select()->from("chat_sessions")->joinInner("leads", "leads.lead_id = chat_sessions.lead_id", array("owner_id"))->where("chat_session_id = ?", $sessionId));
			if ($chat_session["active"]=="Y"){
				$active[] = $sessionId;
			}
		}
		$sessionAgent->chat_sessions = $active;
		foreach($sessionAgent->chat_sessions as $sessionId){
			$chat_session = $db->fetchRow($db->select()->from("chat_sessions")->joinInner("leads", "leads.lead_id = chat_sessions.lead_id", array("owner_id"))->where("chat_session_id = ?", $sessionId));
			if ($chat_session["active"]=="Y"){
				$visitor = $db->fetchRow($db->select()->from("visitors", array("ip"))->where("visitor_id = ?", $chat_session["visitor_id"]));
				$owner = $db->fetchRow($db->select()->from("owners", array("website"))->where("owner_id = ?", $chat_session["owner_id"]));
				if ($sessionAgent->current_chat_session!=$chat_session["chat_session_id"]){
					$unreadMessages = $db->fetchRow($db->select()->from("chats", array("COUNT(*) AS count"))->where("from_id = ?", $chat_session["visitor_id"])->where("notified = 0"));
					$count = $unreadMessages["count"];
				}else{
					$count = 0;
				}
			}
			$output[] = array("chat_session"=>$chat_session, "visitor"=>$visitor, "owner"=>$owner, "unread_messages"=>$count);
		}
		
        
        $this->view->result = array("success"=>true, "chat_sessions"=>$output);
 	    $this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");
    }
    
    public function viewSessionAction(){
    	$db = $this->db;
    	$sessionAgent = new Zend_Session_Namespace("LeadsChat_Auth");
    	if ($sessionAgent->agent_id&&$this->_request->isXmlHttpRequest()){
    		$sessionId = $this->_request->getPost("chat_session_id");	
    		if ($sessionId){		
	    		$chat_session = $db->fetchRow($db->select()->from("chat_sessions")->joinInner("leads", "leads.lead_id = chat_sessions.lead_id", array("owner_id"))->where("chat_session_id = ?", $sessionId));
				$visitor = $db->fetchRow($db->select()->from("visitors", array("ip"))->where("visitor_id = ?", $chat_session["visitor_id"]));
				$owner = $db->fetchRow($db->select()->from("owners", array("owner_id", "first_name", "last_name", "company", "owner_type", "website"))->where("owner_id = ?", $chat_session["owner_id"]));
				$update = array("notified"=>1);
				$db->update("chats", $update, "chats.chat_session_id = {$sessionId}");				
	    		$sessionAgent->current_chat_session = $sessionId;
	    		$this->view->result = array("result"=>true, "chat_session"=>$chat_session, "visitor"=>$visitor, "owner"=>$owner);
    		}else{
	    		$this->view->result = array("result"=>false);	
    		}
    	}else{
    		$this->view->result = array("result"=>false);
    	}
    	$this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");        
    }

	public function endChatAction(){
		$db = $this->db;
        $sessionAgent = new Zend_Session_Namespace("LeadsChat_Auth");
        if ($sessionAgent->agent_id&&$this->_request->isXmlHttpRequest()){
        	$agentId = $sessionAgent->agent_id;
        	$chat_session_id = $this->_request->getPost("chat_session_id");
        	if ($chat_session_id){
        		$chat_session = $db->fetchRow($db->select()->from("chat_sessions")->where("chat_session_id = ?", $chat_session_id));
        		if ($chat_session&&($chat_session["agent_id"]==$agentId)){
        			$db->update("chat_sessions", array("active"=>"N"), "chat_session_id = {$chat_session_id}");
       				$available_agent = $db->fetchRow($db->select()->from("available_agents", array("currently_served"))->where("available_agents.agent_id = ?", $agentId));
       				if ($available_agent){
       					if ($available_agent["currently_served"]>0){
   							$update = array("currently_served"=>$available_agent["currently_served"]-1);    						
       					}else{
       						$update = array("currently_served"=>0);
       					}
       					$db->update("available_agents", $update, "available_agents.agent_id = {$agentId}");
       					$this->view->result = array("success"=>true);
       				}else{
       					$this->view->result = array("success"=>false);
       				}
        		}else{
        			$this->view->result = array("success"=>false);
        		}
        	}else{
        		$this->view->result = array("success"=>false, "message"=>"Invalid Request");
        	}
        }
        $this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");        
	}
	
	public function logoutAction(){
		
		$session = new Zend_Session_Namespace("LeadsChat_Auth");
		if ($session->__isset("agent_id")){
			$this->auth->logout();
		}
		header("Location:/agents/login");
		exit;
	}
    
    public function acceptRequestAction(){
    	$db = $this->db;
        $sessionAgent = new Zend_Session_Namespace("LeadsChat_Auth");
        if ($sessionAgent->agent_id&&$this->_request->isXmlHttpRequest()){
        	$agentId = $sessionAgent->agent_id;
        	$requestId = $this->_request->getPost("requestId");
        	$chatSessions = $this->chatSessionModel->getChatSessionCount($sessionAgent->agent_id);
        	
        	if ($requestId){
        		if ($this->chatRequestModel->isAccepted($requestId)){
        			$this->view->result = array("message"=>"Already accepted", "result"=>false);				
        		}else{
	        		if ($chatSessions>=4){
			   			$this->view->result = array("message"=>"Accept exceed", "result"=>false, "count"=>$chatSessions);				
					}else{
		        		//get the request from database
		        		$sql = $db->select()->from("chat_requests")
		        					->joinInner("visitors", "visitors.visitor_id = chat_requests.visitor_id", array("owner_id"))		        					
		        					->where("chat_request_id = ?", $requestId);
		        		$request = $db->fetchRow($sql);
		        		$date = date("Y-m-d h:i:s");
		        		if ($request){
		        			
		        			
		        			//create actual lead
		        			$lead = array("visitor_id"=>$request["visitor_id"],
		        						"owner_id"=>$request["owner_id"],
		        						"created"=>$date,
		        						"chat_start"=>$date,
		        						);
		        			$lead_id = $this->leadModel->partialCreate($lead);			
		        			//create a chat session
		        			$chat_session = array("visitor_id"=>$request["visitor_id"], 
		     										"agent_id"=>$sessionAgent->agent_id,
		     										"lead_id"=>$lead_id,
		     										"created"=>$date,
		        									"chat_request_id"=>$requestId);
		     				$db->insert("chat_sessions", $chat_session);
		        			$chat_session_id = $db->lastInsertId("chat_sessions");
		        			//create chat activity for both
		        			$chat_activity = array("chatter_id"=>$sessionAgent->agent_id,
		        								   "chatter_type"=>"A",
		        									"chat_session_id"=>$chat_session_id, 
		        									"created"=>$date);
		        			$db->insert("chat_activities", $chat_activity);
		        			$chat_activity = array("chatter_id"=>$request["visitor_id"],
		        								   "chatter_type"=>"V",
		        									"chat_session_id"=>$chat_session_id, 
		        									"created"=>$date);
		        			$db->insert("chat_activities", $chat_activity);
		        			
		        			//create initial welcome message
		        			$agent = $db->fetchRow($db->select()->from("agents", array("first_name"))
		        							->where("agent_id = ?", $agentId));
		        			$message = "Hi. I am {$agent["first_name"]}. How may I serve you?";
		        			$chat = array("from_id"=>$agentId, "from_type"=>"A", "message"=>$message, "created"=>$date, "chat_session_id"=>$chat_session_id);
		        			$db->insert("chats", $chat);
		        			
		        			
		        			
		        			$accepted = array("accepted"=>"Y");
		        			$db->update("chat_requests", $accepted, "chat_request_id = ".$request["chat_request_id"]);
		        			
		        			
		        			$available_agent = $db->fetchRow($db->select()->from("available_agents", array("currently_served"))->where("available_agents.agent_id = ?", $sessionAgent->agent_id));
		        			
		        			$chatRequests = $this->chatRequestModel->getRequestCountForAgent($sessionAgent->agent_id);
		        			
		        			if ($chatRequests["count"]>=4){
		    	    			$accepted = array("available"=>"N", "currently_served"=>$chatRequests["count"]);	
		        			}else{
		        				$accepted = array("available"=>"Y", "currently_served"=>$available_agent["currently_served"]+1);
		        			}
		        			
		        			$db->update("available_agents", $accepted, "agent_id = ".$sessionAgent->agent_id);
		        			
		        			
		        			//sessionize accepted chat sessions
		        			if (!$sessionAgent->__isset("chat_sessions")){
		        				$sessionAgent->chat_sessions = array();	
		        			} 
		        			$sessionAgent->chat_sessions[] = $chat_session_id;
		        			$this->view->result = array("chat_session_id"=>$chat_session_id, "result"=>true);      			
		        			
		        		}else{
		        			$this->view->result = array("message"=>"Invalid Request", "result"=>false);
		        		}
					}
        		}

        	}
        }
        $this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");        
        
    }
    
    public function loginAction(){
    	$db = $this->db;
    	if ($this->auth->isAuthenticated()){
    		if (UserMap::getRole()==UserMap::$ADMIN){
    			header("Location:/admin/");
    		}else{
    			header("Location:/agents/dashboard/");
    		}
    		exit;
    	}
    	$this->view->loginForm = new Agent_Login();
    	$this->view->headTitle("Login");
    	$this->view->headScript()->appendFile($this->baseUrl."/js/jquery.js", "text/javascript");
    	$this->view->headScript()->appendFile($this->baseUrl."/js/jquery.validate.min.js", "text/javascript");
    	$this->view->headScript()->appendFile($this->baseUrl."/js/agents/agent_login.js", "text/javascript");
    	$this->view->headLink()->appendStylesheet($this->baseUrl."/css/agent/login.css");
    }
    
    
    public function processLoginAction(){
    	$sessionAgent = new Zend_Session_Namespace("LeadsChat_Auth");   
        if (!$sessionAgent->agent_id&&$this->_request->isXmlHttpRequest()){
			if ($this->auth->authenticate()){
				$this->view->result = array("result"=>true, "message"=>"Successful logged in", "level"=>UserMap::getRole());
			}else{
				$this->view->result = array("result"=>false, "message"=>"Invalid Username/Password");
			}   			    	
        }else{
        	if ($sessionAgent->agent_id){
        		$this->view->result = array("result"=>true, "message"=>"Already logged in");
        	}else{
        		$this->view->result = array("result"=>false, "message"=>"Invalid request method");	
        	}	
        }
        $this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");
    }
    
    public function dashboardAction(){
    	if (!$this->auth->isAuthenticated()){
    		header("Location:/agents/login/");
    		exit;
    	}
		$infoForm = new Lead_InfoForm();
    	$agent = $this->auth->getUser();
		$this->view->admin = ($agent["type"]=="Admin");			
		$this->view->user = $agent;
		$this->view->infoForm = $infoForm;
    	
    	$this->view->headTitle("Home - Dashboard");
    	$this->view->headScript()->appendFile($this->baseUrl."/js/jquery.js", "text/javascript");
    	$this->view->headScript()->appendFile($this->baseUrl."/js/jquery.validate.min.js", "text/javascript");
    	$this->view->headScript()->appendFile($this->baseUrl."/js/agents/dashboard.js", "text/javascript");
    	$this->view->headLink()->prependStylesheet($this->baseUrl."/css/agent/dashboard.css");
    	$this->_helper->layout->setLayout("agent-portal");        
    }
    
    
    public function listAction(){
    	$agents = $this->agentModel->listAgents();
    	foreach ($agents as $key=>$agent){
    		unset($agents[$key]["password"]);
    	}
    	$this->view->result = array("success"=>true, "dataLoaded"=>$agents);
    	$this->_helper->layout->setLayout("plain");
    	$this->_helper->viewRenderer("json");
    }
    
    public function listAllAction(){
    	$agents = $this->agentModel->listAll();
    	foreach ($agents as $key=>$agent){
    		unset($agents[$key]["password"]);
    	}
    	$this->view->result = array("success"=>true, "dataLoaded"=>$agents);
    	$this->_helper->layout->setLayout("plain");
    	$this->_helper->viewRenderer("json");
 
    }

}

