<?php 
class App_Owner extends AppModel{
	protected $_name = "owners";
	protected $_primary = "owner_id";
	
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
	
	
	public function listAll($page, $count, $detailed = false){
		
		$select = $this->getAdapter()->select();
		
		$sql = $select->from($this->_name, array("owner_id", "first_name", "last_name", "website",
											  "company", "email", "username", 
											  "activated", "credits", "owner_type",
											  "timezone_id", "mobile", "number_hits",
											  "approved", "deleted", "fullname_webmaster",
											  "email_webmaster", "phone_webmaster",
											  "date_created", "date_updated"))
							  ->order("date_created DESC");
							  
		if ($page!=null&&$count!=null){
			$sql = $sql->limitPage($page, $count);
		}else{
			$sql = $sql->limitPage(1, 50);
		}
		$result = $this->getAdapter()->fetchAll($sql);	
		$appTimezone = new App_Timezone();
		if ($detailed){
			foreach($result as $key=>$value){
				try{
					$result[$key]["timezone"] = $appTimezone->find($value["timezone_id"])->getRow(0)->toArray();	
				}catch(Exception $e){
					$result[$key]["timezone"] = null;
				}
			}
		}
		return $result;
	}
	
	public function isEmailExist($email){
		$select = $this->select();
		return $this->fetchRow($select->where("email = ?", $email))!=null;
	}

	public function isUsernameExist($username){
		$select = $this->select();
		return $this->fetchRow($select->where("username = ?", $username))!=null;
	}
	
	
}
