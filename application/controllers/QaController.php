<?php
class QaController extends AppController{
	private $model;
	
	public function init(){
		parent::init();
		$this->model = new App_Agent();
	}
	
	public function indexAction(){
		$this->view->headTitle("Leads Chat - Admin Home");
		$this->view->headScript()->appendFile($this->baseUrl."/js/ext/ext-debug.js", "text/javascript");
		$this->view->headScript()->appendFile($this->baseUrl."/js/qa.js", "text/javascript");
		$this->view->headLink()->appendStylesheet($this->baseUrl."/js/ext/resources/css/ext-all.css");
	}
	
	
	public function listAction(){
		$qas = $this->model->listQAs();
		foreach ($qas as $key=>$qa){
			unset($qas[$key]["password"]);
		}
		$this->view->result = array("success"=>true, "dataLoaded"=>$qas);
		$this->_helper->layout->setLayout("plain");
        $this->_helper->viewRenderer("json");     
	}
	
}