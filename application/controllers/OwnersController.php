<?php 
class OwnersController extends BaseLeadController{
	private $model;
	
	private $ownerModel, $timezoneModel;
	public function init(){
		parent::init();
		$this->auth = AuthFactory::create(AuthFactory::$OWNER, $this->db, $this->_request);
		$this->model = new Owner_Owner($this->db);
		$this->model->setRequestObject($this->_request);
		$this->ownerModel = new App_Owner(array("db"=>"main_db"));
		$this->timezoneModel = new App_Timezone(array("db"=>"main_db"));
	}


	public function processListAction(){
		$result = $this->ownerModel->listAll($this->_request->getQuery["page"], $this->_request->getQuery["count"], true);
		$this->view->result = array("result"=>true, "dataLoaded"=>$result);
		$this->_helper->layout->setLayout("plain");
		$this->_helper->viewRenderer("json");
	}
	
	
	public function processRegisterAction(){
		$db = $this->db;
		if ($this->_request->isXmlHttpRequest()){
					//auto mail here
			$validationSettings = array();
			$validationSettings[] = array("field"=>"first_name",
									"configs"=>array(array("validation"=>"required")));
			$validationSettings[] = array("field"=>"last_name",
									"configs"=>array(array("validation"=>"required")));
			$validationSettings[] = array("field"=>"website",
									"configs"=>array(array("validation"=>"required")));
			$validationSettings[] = array("field"=>"company",
									"configs"=>array(array("validation"=>"required")));
			$validationSettings[] = array("field"=>"email",
									"configs"=>array(array("validation"=>"required")));
			$validationSettings[] = array("field"=>"username",
									"configs"=>array(array("validation"=>"required")));
			$validationSettings[] = array("field"=>"password",
									"configs"=>array(array("validation"=>"required")));
			$validationSettings[] = array("field"=>"working_timezone",
									"configs"=>array(array("validation"=>"required")));
			$validationSettings[] = array("field"=>"mobile",
									"configs"=>array(array("validation"=>"required"),
													 array("validation"=>"exist", "settings"=>array("table"=>"owners"))));
			
			$this->model->setValidationSettings($validationSettings);
			
			if ($this->model->create()){
				$this->view->result = array("result"=>true);
			}else{			
				$this->view->result = array("result"=>false, "errors"=>$this->model->getErrors());
			}
		}else{
			$this->view->result = array("result"=>false);
		}
		$this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");
	}
	
	
	public function adminMainAction(){
					
	}
		
	public function processLoginAction(){
    	$sessionAgent = new Zend_Session_Namespace("LeadsChat_Owner_Auth");   
        if (!$sessionAgent->owner_id&&$this->_request->isXmlHttpRequest()){
			if ($this->auth->authenticate()){
				$this->view->result = array("result"=>true, "message"=>"Successful logged in");
			}else{
				$this->view->result = array("result"=>false, "message"=>"Invalid Username/Password");
			}   			    	
        }else{
        	if ($sessionAgent->owner_id){
        		$this->view->result = array("result"=>true, "message"=>"Already logged in");
        	}else{
        		$this->view->result = array("result"=>false, "message"=>"Invalid request method");	
        	}	
        }
        $this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");
    }
    
    public function indexAction(){
    	$sessionAgent = new Zend_Session_Namespace("LeadsChat_Owner_Auth");
		$this->view->headTitle("Leads Chat - Home");
		$this->view->headScript()->appendFile($this->baseUrl."/js/jquery.js", "text/javascript");
		$this->view->headScript()->appendFile($this->baseUrl."/js/owner-dashboard.js", "text/javascript");
		$this->view->headLink()->appendStylesheet($this->baseUrl."/css/owner-dashboard.css");    	
    }
    

	public function registerAction(){
		$this->view->headTitle("Leads Chat - Register");
		$this->view->headScript()->appendFile($this->baseUrl."/js/jquery.js", "text/javascript");
		$this->view->headScript()->appendFile($this->baseUrl."/js/owner-register.js", "text/javascript");
		$this->view->headLink()->appendStylesheet($this->baseUrl."/css/register.css");
	}
	
	public function forgotpasswordAction(){
		$this->view->headTitle("Leads Chat - Forgot Password");
		$this->view->headScript()->appendFile($this->baseUrl."/js/jquery.js", "text/javascript");
		$this->view->headLink()->appendStylesheet($this->baseUrl."/css/owner-login.css");
	}

	public function loginAction(){
		$this->view->headTitle("Leads Chat - Login");
		$this->view->headScript()->appendFile($this->baseUrl."/js/jquery.js", "text/javascript");
		$this->view->headLink()->appendStylesheet($this->baseUrl."/css/owner-login.css");
	}
	
}