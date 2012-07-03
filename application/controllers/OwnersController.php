<?php 
/**
 * @copyright Intuitive Marketing LLC
 * @author Allanaire Tapion
 *
 */
class OwnersController extends AppController{
	private $model;
	private $ownerModel, $timezoneModel, $timezoneGroupModel, $businessTypeModel, $numberOfHitModel;
	public function init(){
		parent::init();
		$this->auth = AuthFactory::create(AuthFactory::$OWNER, $this->db, $this->_request);
		$this->model = new Owner_Owner($this->db);
		$this->model->setRequestObject($this->_request);
		$this->ownerModel = new App_Owner();
		$this->timezoneModel = new App_Timezone();
		$this->timezoneGroupModel = new App_TimezoneGroup();
		$this->businessTypeModel = new App_BusinessType();
		$this->numberOfHitModel = new App_NumberOfHit();		
	}

	/**
	 * List of owners
	 */
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
	
	/**
	 * Process Register action
	 */
	public function processRegisterAction(){
		$db = $this->db;
		$form = new Owner_Registration();		
		if ($this->_request->isXmlHttpRequest()&&$form->isValid($_POST)){
			$data = $form->getValidValues($_POST);
			$newRecord = $this->ownerModel->create($data);
			//query newly create record
			$owner = $this->ownerModel->find($newRecord)->toArray();
			
			$this->view->result = array("result"=>true);
		}else{
			$this->view->result = array("result"=>false, "errors"=>$form->getErrors());
		}
		$this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");
	}
	
	/**
	 * Verify email link
	 */
	public function verifyEmailAction(){
		$hashcode = $this->getRequest()->getQuery("hashcode");
		if (!$this->ownerModel->isActivated($hashcode)){
			$this->ownerModel->activateAccount($hashcode);

			//render congratulation page
			$this->_helper->layout->setLayout("plain");
        	$this->_helper->viewRenderer("congrats_activated");
		}else{

			$this->_helper->layout->setLayout("plain");
        	$this->_helper->viewRenderer("already_activated");
		}
		
	}
	
	
	/**
	 * Process admin main on Owners Controller
	 */
	public function adminMainAction(){
		$this->view->headTitle("Leads Chat - Admin Home");
		$this->view->headScript()->appendFile($this->baseUrl."/js/ext/ext-debug.js", "text/javascript");
		$this->view->headScript()->append+File($this->baseUrl."/js/app.js", "text/javascript");
		$this->view->headLink()->appendStylesheet($this->baseUrl."/js/ext/resources/css/ext-all.css");
	}
	
	/**
	 * Process login request via ajax
	 */
	public function processLoginAction(){
    	$sessionAgent = new Zend_Session_Namespace("LeadsChat_Owner_Auth"); 
    	$form = new Owner_Login();  
        if (!$sessionAgent->owner_id&&$this->_request->isXmlHttpRequest()&&$form->isValid($_POST)){
			if ($this->auth->authenticate()){
				$this->view->result = array("result"=>true, "message"=>"Successful logged in");
			}else{
				$this->view->result = array("result"=>false, "message"=>"Invalid Username/Password");
			}  			    	
        }else{
        	if(!$this->_request->isXmlHttpRequest()){
        		$this->view->result = array("result"=>false, "message"=>"Invalid request method");
        	}
        	if (!$form->isValid($_POST)){
        		$this->view->result = array("result"=>false, "message"=>"Error", "error"=>$form->getErrors());
        	}
        	
        	if ($sessionAgent->owner_id){
        		$this->view->result = array("result"=>true, "message"=>"Already logged in");
        	}	
        }
        $this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");
    }
    
    /**
     * The home page for owners dashboard
     */
    public function indexAction(){
    	$sessionAgent = new Zend_Session_Namespace("LeadsChat_Owner_Auth");
		$this->view->headTitle("Leads Chat - Home");
		$this->view->headScript()->appendFile($this->baseUrl."/js/jquery.js", "text/javascript");
		$this->view->headScript()->appendFile($this->baseUrl."/js/owner-dashboard.js", "text/javascript");
		$this->view->headLink()->appendStylesheet($this->baseUrl."/css/owner-dashboard.css");    	
    }
    
    /**
	 * Process a forgot password request.
	 * @params emailAddress the email address
	 */
    public function processForgotPasswordAction(){
		$form = new Owner_ForgotPassword();
		if (!$this->getRequest()->isXmlHttpRequest()){
			$this->view->result = $this->_invalidRequest();
		}
		if (!$form->isValid($_POST)){
			$this->view->result = array("success"=>false, "errors"=>$form->getErrors());
		}

    	$emailAddress = $this->getRequest()->getPost("email_address");
		$hashcode = $this->ownerModel->forgotPassword($emailAddress);
		if ($hashcode){
			//mail here
			$this->view->result = array("success"=>true);
		}else{
			$this->view->result = $this->_invalidRequest();
		}	
		$this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");
    }
    
    /**
     * Reset password action
     */
    public function resetPasswordAction(){
    	$this->view->form = new Owner_ResetPassword();
    }
    
    
    /**
     * Resets password via ajax
     */
    public function processResetPasswordAction(){
    	$form = new Owner_ResetPassword();
		if (!$this->getRequest()->isXmlHttpRequest()){
			$this->view->result = $this->_invalidRequest();
		}
		if (!$form->isValid($_POST)){
			$this->view->result = array("success"=>false, "errors"=>$form->getErrors());
		}
		$values = $form->getValidValues($_POST);
		if ($values["new_password"]==$values["confirm_password"]){
			$this->view->result = array("success"=>false, "error"=>"The passwords did not match");
		}
		
		if ($this->ownerModel->resetPassword($values["owner_id"], $values["new_password"])){
			$this->view->result = array("success"=>true);
		}else{
			$this->view->result = array("success"=>false, "error"=>"Reset Failed");
		}
    }
    
    
	/**
	 * Register an owner to site
	 */
	public function registerAction(){
		
		$form = new Owner_Registration();
		$this->view->headTitle("Leads Chat - Register");
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
	
	/**
	 * Check if email is existing
	 */
	public function emailExistingAction(){
		$email = $this->_request->getQuery("email");
		if ($this->_request->isXmlHttpRequest()&&$email!=""){
			$this->view->result = array("success"=>$this->ownerModel->isEmailExist($email));
		}else{
			$this->view->result = array("success"=>false);
		}
		$this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");
	}
	
	
	/**
	 * Check if Username is existing
	 */
	public function usernameExistingAction(){
		$username = $this->_request->getQuery("username");
		if ($this->_request->isXmlHttpRequest()&&$username!=""){
			$this->view->result = array("success"=>$this->ownerModel->isUsernameExist($username));
		}else{
			$this->view->result = array("success"=>false);
		}
		$this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");
	}
	
	
	
	/**
	 * Forgot password action
	 */
	public function forgotPasswordAction(){
		$form = new Owner_ForgotPassword();
		$this->view->form = $form;
		$this->view->headTitle("Leads Chat - Forgot Password");
		$this->view->headScript()->appendFile($this->baseUrl."/js/jquery.js", "text/javascript");
		$this->view->headLink()->appendStylesheet($this->baseUrl."/css/owner-login.css");
	}
	
	
	/**
	 * Checks if owner is login
	 */
	public function isloginAction(){
		if ($this->_request->isXmlHttpRequest()){
			$this->view->result = array("result"=>$this->auth->isAuthenticated());
		}else{
			$this->view->result = array("result"=>false);
		}
		$this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");
	}

	/**
	 * Login a user action
	 */
	public function loginAction(){
		$form = new Owner_Login();
		$this->view->form = $form;		
		$this->view->headTitle("Leads Chat - Login");
		$this->view->headScript()->appendFile($this->baseUrl."/js/jquery.js", "text/javascript");
		$this->view->headScript()->appendFile($this->baseUrl."/js/owner-login.js", "text/javascript");
		$this->view->headLink()->appendStylesheet($this->baseUrl."/css/owner-login.css");
	}
	
	
	/**
	 * Logout an owner from login
	 */
	public function logoutAction(){
		$this->auth->logout();
		header("Location:/owners/login");
		exit;
	}
	
	/**
	 * Process an approval on Owner
	 */
	public function processApproveAction(){
		$owner_id = $this->getRequest()->getPost("owner_id");
		if ($owner_id){
			if ($this->ownerModel->approve($owner_id)){
				$this->view->result = array("success"=>true);
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