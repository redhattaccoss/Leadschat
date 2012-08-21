<?php

class IndexController extends AppController
{

    public function indexAction()
    {
        // action body
    	$this->view->headTitle("Leads Chat");
    	$this->view->headScript()->appendFile($this->baseUrl."/js/jquery-1.7.1.min.js", "text/javascript");
    	$this->view->headScript()->appendFile($this->baseUrl."/js/ui.core.js", "text/javascript");
    	$this->view->headScript()->appendFile($this->baseUrl."/js/ui.tabs.js", "text/javascript");
    	$this->view->headScript()->appendFile($this->baseUrl."/js/index.js", "text/javascript");
    	 
    	$this->view->headLink()->appendStylesheet($this->baseUrl."/css/stylesheet.css");
    	$this->view->headLink()->appendStylesheet($this->baseUrl."/css/ui.tabs.css", "print, projection, screen");
    	$this->view->headLink()->appendStylesheet($this->baseUrl."/css/custom.css");
    	$this->_helper->layout->setLayout("html4");
    }

    
    public function aboutAction(){
    	$this->view->headTitle("Leadschat - About Us");
   		$this->_loadBaseBlogResources();
		$this->view->sidebar = "content-navigation.phtml";
    	$this->_helper->layout->setLayout("blog");
    }
    
    
    public function contactAction(){
    	$this->view->headTitle("Leadschat - Contact Us");
    	$this->_loadBaseBlogResources();
    	$this->_helper->layout->setLayout("html4");
    }
 
    public function pricingAction(){
    	$this->view->headTitle("Leadschat - Pricing");
    	$this->_loadBaseBlogResources();
    	 
    	$this->_helper->layout->setLayout("html4");
    }
    
    public function howItWorksAction(){
    	$this->view->headTitle("Leadschat - How it Works");
    	$this->_loadBaseBlogResources();
		$this->view->sidebar = "navigation-how-it-works.phtml";
    	$this->_helper->layout->setLayout("blog");
    }
	
	public function whyAction(){
    	$this->view->headTitle("Why Leadschat");
    	$this->_loadBaseBlogResources();
		$this->view->sidebar = "navigation-how-it-works.phtml";
    	$this->_helper->layout->setLayout("blog");
    }
	
	public function benefitsLivechatAction(){
    	$this->view->headTitle("Leadschat - Benefits of Livechat");
    	$this->_loadBaseBlogResources();
		$this->view->sidebar = "navigation-how-it-works.phtml";
    	$this->_helper->layout->setLayout("blog");
    }
	
	
       
    private function _loadBaseBlogResources(){
    	$this->view->headScript()->appendFile($this->baseUrl."/js/jquery-1.7.1.min.js", "text/javascript");
    	$this->view->headLink()->appendStylesheet($this->baseUrl."/css/stylesheet.css");
    	$this->view->headLink()->appendStylesheet($this->baseUrl."/css/custom.css");
    }
}

