<?php
class QaController extends AppController{
	public function init(){
		
	}
	
	public function indexAction(){
		$this->view->headTitle("Leads Chat - Admin Home");
		$this->view->headScript()->appendFile($this->baseUrl."/js/ext/ext-debug.js", "text/javascript");
		$this->view->headScript()->appendFile($this->baseUrl."/js/qa.js", "text/javascript");
		$this->view->headLink()->appendStylesheet($this->baseUrl."/js/ext/resources/css/ext-all.css");
	}
}