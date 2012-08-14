<?php
class CallCenterController extends AppController{
	private $model;
	
	public function init(){
		$this->model = new App_CallCenter();
	}
	
	public function listAction(){
		$call_centers = $this->model->fetchAll()->toArray();		
		foreach($call_centers as $key=>$call_center){
			unset($call_center[$key]["password"]);
		}
		$this->view->result = array("success"=>true, "dataLoaded"=>$call_centers);
		$this->_helper->layout->setLayout("plain");
		$this->_helper->viewRenderer("json");
	}
}