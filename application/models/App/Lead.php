<?php 
class App_Lead extends AppModel{
	protected $_name = "leads";
	protected $_primary = "lead_id";
	
	public function partialCreate($data){
		$validationSettings = array();
		$validationSettings[] = array("field"=>"visitor_id",
								"configs"=>array(array("validation"=>"required")));
		$validationSettings[] = array("field"=>"owner_id",
								"configs"=>array(array("validation"=>"required")));
		$validationSettings[] = array("field"=>"created",
								"configs"=>array(array("validation"=>"required")));
		$validationSettings[] = array("field"=>"chat_start",
								"configs"=>array(array("validation"=>"required")));
		$this->_validationSettings = $validationSettings;
		if ($this->validateData($data)){
			$this->insert($data);
			return $this->getAdapter()->lastInsertId();	
		}else{
			return false;
		}
		
	}
}