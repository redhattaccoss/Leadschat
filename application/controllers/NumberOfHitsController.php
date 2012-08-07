<?php
class NumberOfHitsController extends AppController{
	
	private $model;
	public function init(){
		parent::init();
		$this->model = new App_NumberOfHit();
	}
	
	
	public function listAction(){
		$this->view->result = array("success"=>true, "dataLoaded"=>$this->model->fetchAll()->toArray());
		$this->_helper->layout->setLayout("plain");
		$this->_helper->viewRenderer("json");
	}
}