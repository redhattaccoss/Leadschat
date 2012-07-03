<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

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
    	$this->_helper->layout->setLayout("plain");
    	
    }


}

