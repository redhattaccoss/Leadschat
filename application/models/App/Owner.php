<?php 
class App_Owner extends AppModel{
	protected $_name = "owners";
	protected $_schema = "owners";
	
	public function create($data){
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
												 
		$this->_validationSettings = $validationSettings;
		if ($this->validateData($data)){
			$this->insert($data);
			return $this->getAdapter()->lastInsertId();	
		}else{
			return false;
		}
	}
}
