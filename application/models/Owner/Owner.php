<?php 
class Owner_Owner extends BaseModel{
	
	public function create($request=null){
		$db = $this->db;
		$this->_skipFields = array("confirmpassword");
		if ($request!=null){
			$this->_request = $request;
		}
		if ($this->validate()){
			$data = $this->getPostData();
			$data["password"] = md5($data["password"]);
			$db->insert("owners", $data);	
			return true;
		}else{
			return false;
		}
	}
}