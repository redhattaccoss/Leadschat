<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload(){
		require_once APPLICATION_PATH.DIRECTORY_SEPARATOR."controllers/BaseLeadController.php";
		$models = APPLICATION_PATH.DIRECTORY_SEPARATOR."models";
		$forms = APPLICATION_PATH.DIRECTORY_SEPARATOR."forms";
		
		/* Initialize action controller here */
		Zend_Loader::loadClass("BaseModel", array($models));
    	Zend_Loader::loadClass("Db_Ip", array($models));
    	Zend_Loader::loadClass("Db_Db", array($models));
    	Zend_Loader::loadClass("Authentication", array($models));
    	Zend_Loader::loadClass("Agent_Auth", array($models));
    	Zend_Loader::loadClass("AuthFactory", array($models));
    	Zend_Loader::loadClass("Agent_Login", array($forms));
    	Zend_Loader::loadClass("Chat_Request", array($models));
    	Zend_Loader::loadClass("Chat_Session", array($models));
    	Zend_Loader::loadClass("Lead_InfoForm", array($forms));
    	Zend_Loader::loadClass("Owner_Owner", array($models));
    	Zend_Loader::loadClass("Owner_Auth", array($models));
    	Zend_Layout::startMvc();
    	$layout = Zend_Layout::getMvcInstance();
		$layout->setLayoutPath(APPLICATION_PATH.DIRECTORY_SEPARATOR."views/layouts");
	}
	
	public function _initView(){
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

}

