<?php 
class OwnersController extends BaseLeadController{
	private $model;
	private $ownerModel, $timezoneModel, $timezoneGroupModel, $businessTypeModel, $numberOfHitModel;
	public function init(){
		parent::init();
		$this->auth = AuthFactory::create(AuthFactory::$OWNER, $this->db, $this->_request);
		$this->model = new Owner_Owner($this->db);
		$this->model->setRequestObject($this->_request);
		$this->ownerModel = new App_Owner(array("db"=>"main_db"));
		$this->timezoneModel = new App_Timezone(array("db"=>"main_db"));
		$this->timezoneGroupModel = new App_TimezoneGroup();
		$this->businessTypeModel = new App_BusinessType();
		$this->numberOfHitModel = new App_NumberOfHit();		
	}

	public function processListAction(){
		$result = $this->ownerModel->listAll($this->_request->getQuery["page"], $this->_request->getQuery["count"], true);
		if (!empty($result)){
			foreach($result as $key=>$value){
				$result[$key]["selected"] = false;
			}
		}
		
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
		$this->view->headTitle("Leads Chat - Admin Home");
		$this->view->headScript()->appendFile($this->baseUrl."/js/ext/ext-debug.js", "text/javascript");
		$this->view->headScript()->appendFile($this->baseUrl."/js/app.js", "text/javascript");
		$this->view->headLink()->appendStylesheet($this->baseUrl."/js/ext/resources/css/ext-all.css");
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
		
		$form = new Owner_Registration();
		$timezoneId = $form->getElement("timezone_id");
		$number_hits = $form->getElement("number_of_hit_id");
		$this->view->headTitle("Leads Chat - Register");
		$timezoneGroups = $this->timezoneGroupModel->getAllTimezonesGrouped();
		$items = array();
		$items[""] = "Please Select";
		foreach($timezoneGroups as $timezoneGroup){
			$timezones = $timezoneGroup["timezones"];
			foreach($timezones as $timezone){
				$items[$timezoneGroup["name"]][$timezone["timezone_id"]]=$timezone["name"];
			}
		}
		$timezoneId->addMultiOptions($items);
		
		
		$items = array();
		$items[""] = "Please Select";
		$hits = $this->numberOfHitModel->fetchAll()->toArray();
		foreach($hits as $hit){
			$items[$hit["id"]] = $hit["name"];
		}
		
		$number_hits->addMultiOptions($items);
		
		$this->view->timezoneGroups = $this->timezoneModel->fetchAll()->toArray();
		$this->view->registration_form = $form;
		//render include files
		$this->view->headScript()->appendFile($this->baseUrl."/js/jquery-1.7.2.js");
		$this->view->headScript()->appendFile($this->baseUrl."/js/jquery-ui-1.8.21.custom.min.js", "text/javascript");	
		$this->view->headScript()->appendFile($this->baseUrl."/js/jquery.validate.min.js", "text/javascript");
		$this->view->headScript()->appendFile($this->baseUrl."/js/ui/jquery.ui.selectmenu.js", "text/javascript");
		$this->view->headScript()->appendFile($this->baseUrl."/js/owner-register.js", "text/javascript");
		$this->view->headLink()->appendStylesheet($this->baseUrl."/css/themes/ui-darkness/jquery-ui-1.8.21.custom.css");
		$this->view->headLink()->appendStylesheet($this->baseUrl."/css/themes/base/jquery.ui.selectmenu.css");
		
		$this->view->headLink()->appendStylesheet($this->baseUrl."/css/register.css");
		
	}
	
	
	public function emailExistingAction(){
		$email = $this->_request->getQuery("email");
		if ($this->_request->isXmlHttpRequest()&&$email){
			$this->view->result = array("success"=>$this->ownerModel->isEmailExist($email));
		}else{
			$this->view->result = array("success"=>false);
		}
		$this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");
	}
	public function usernameExistingAction(){
		$username = $this->_request->getQuery("username");
		if ($username){
			$this->view->result = array("success"=>$this->ownerModel->isUsernameExist($username));
		}else{
			$this->view->result = array("success"=>false);
		}
		$this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");
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