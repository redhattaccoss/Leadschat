<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload(){
		$this->loadLibraries();
		$this->loadOldClasses();
		//load the database adapter
		$connectionParameters = Db_Db::getConnectionParameters();
		$this->loadNewClasses();	
		$db = Zend_Db::factory("PDO_MYSQL", $connectionParameters);
		Zend_Registry::set("main_db", $db);
		Db_Mongo::instantiate();
		Zend_Db_Table_Abstract::setDefaultAdapter($db);
		Zend_Layout::startMvc();
    	$layout = Zend_Layout::getMvcInstance();
		$layout->setLayoutPath(APPLICATION_PATH.DIRECTORY_SEPARATOR."views/layouts");
		
	}
	
	private function loadLibraries(){
		$views = APPLICATION_PATH.DIRECTORY_SEPARATOR."views";
		$models = APPLICATION_PATH.DIRECTORY_SEPARATOR."models";
		Zend_Loader::loadClass("Converter", array($models));
	}
	
	
	private function defineACL(){
		$acl = new Zend_Acl();
		$acl->addRole(new Zend_Acl_Role("admin"))
			->addRole(new Zend_Acl_Role("agent"))
			->addRole(new Zend_Acl_Role("member"))
			->addRole(new Zend_Acl_Role("owner"));
	
	}
	
	private function _initSetupBaseUrl(){
		$this->bootstrap('frontcontroller');
		$ctrl = Zend_Controller_Front::getInstance();
		$router = $ctrl->getRouter();
		$route = new Zend_Controller_Router_Route_Static("about/*",
					array("controller"=>"index", "action"=>"about"));
		$router->addRoute("about", $route);
	}
	
	/**
	 * These are old classes ...
	 */
	private function loadOldClasses(){
		require_once APPLICATION_PATH.DIRECTORY_SEPARATOR."controllers/AppController.php";
		$models = APPLICATION_PATH.DIRECTORY_SEPARATOR."models";
		$forms = APPLICATION_PATH.DIRECTORY_SEPARATOR."forms";
		require_once $models."/CRUD.php";
		/* Initialize action controller here */
		Zend_Loader::loadClass("AppModel", array($models));
		Zend_Loader::loadClass("BaseModel", array($models));
    	Zend_Loader::loadClass("Db_Ip", array($models));
    	Zend_Loader::loadClass("Db_Db", array($models));
    	Zend_Loader::loadClass("Authentication", array($models));
    	Zend_Loader::loadClass("AuthenticationModel", array($models));
    	Zend_Loader::loadClass("Agent_Auth", array($models));
    	Zend_Loader::loadClass("AuthFactory", array($models));
    	Zend_Loader::loadClass("Agent_Login", array($forms));
    	Zend_Loader::loadClass("Chat_Request", array($models));
    	Zend_Loader::loadClass("Chat_Session", array($models));
    	Zend_Loader::loadClass("Lead_InfoForm", array($forms));
    	Zend_Loader::loadClass("Owner_Owner", array($models));
    	Zend_Loader::loadClass("Owner_Auth", array($models));
	}
	
	private function loadNewClasses(){
		$models = APPLICATION_PATH.DIRECTORY_SEPARATOR."models";
		$forms = APPLICATION_PATH.DIRECTORY_SEPARATOR."forms";
			
			
		Zend_Loader::loadClass("App_Chat", array($models));
		Zend_Loader::loadClass("App_ChatSession", array($models));
		Zend_Loader::loadClass("App_ChatRequest", array($models));	
		Zend_Loader::loadClass("App_Owner", array($models));
		Zend_Loader::loadClass("App_Visitor", array($models));	
		Zend_Loader::loadClass("App_Lead", array($models));
		Zend_Loader::loadClass("App_Timezone", array($models));	
		Zend_Loader::loadClass("App_TimezoneGroup", array($models));
		Zend_Loader::loadClass("App_BusinessType", array($models));
		Zend_Loader::loadClass("App_NumberOfHit", array($models));
		Zend_Loader::loadClass("Owner_Registration", array($forms));
    	Zend_Loader::loadClass("Owner_ForgotPassword", array($forms));
    	Zend_Loader::loadClass("Owner_Login", array($forms));
		Zend_Loader::loadClass("Owner_ResetPassword", array($forms));
		Zend_Loader::loadClass("Db_Mongo", array($models));
    	Zend_Loader::loadClass("UserMap", array($models));
    	Zend_Loader::loadClass("Acl", array($models));
    	Zend_Loader::loadClass("Mailer", array($models));
	}
	
	protected function _initView(){
		// Initialize view
        $view = new Zend_View();
        $view->addScriptPath(APPLICATION_PATH . '/views/scripts/');
        // Add it to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
            'ViewRenderer'
        );
        $viewRenderer->setView($view);
		return $view;
	}
	
	protected function _initUser(){
		Zend_Registry::set("user", UserMap::getUser());
	}
	
	protected function _initAcl(){
		$acl = new Acl();
		Zend_View_Helper_Navigation_HelperAbstract::setDefaultAcl($acl);
		Zend_View_Helper_Navigation_HelperAbstract::setDefaultRole(UserMap::getRole());
		Zend_Registry::set('Zend_Acl', $acl);
		return $acl;
	}	

}

