<?php 

class Owner_Owner extends BaseModel implements CRUD {

	public function init(){
		parent::init();
		$this->_table = "owners";
	}
	public function create($request=null){
		$db = $this->db;
		$this->_skipFields = array("confirmpassword");
		if ($request!=null){
			$this->_request = $request;
		}
		if ($this->validate()){
			$data = $this->getPostData();
			$data["password"] = md5($data["password"]);
			$data["hashcode"] = md5($data["hashcode"]);
			$db->insert($this->_table, $data);	
			return true;
		}else{
			return false;
		}
	}
	
	public function update($request=null){
		
	}
	public function delete($request=null){
		
	}
	public function read($condition=array()){
		
	}
}