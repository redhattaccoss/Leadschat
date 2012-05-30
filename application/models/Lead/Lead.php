<?php 
class Lead_Lead extends BaseModel implements CRUD{
	public function init(){
		parent::init();
		$this->_table = "leads";
	}
	public function update($request=null){
		
	}
	public function delete($request=null){
		
	}
	public function read($condition=array()){
		
	}
	public function create($request=null){
		if (is_array($request))	{
			
		}
	}
	/**
	 * Partially creates a leads data after accepting chat request ...
	 * @param $data The data to be saved
	 */
	public function partialCreate($data){
		$db = $this->db;
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
			$db->insert($this->_table, $data);
			return $db->lastInsertId($this->_table);
		}
	}
	
}