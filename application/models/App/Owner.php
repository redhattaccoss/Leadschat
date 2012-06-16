<?php 
class App_Owner extends AppModel{
	protected $_name = "owners";
	protected $_primary = "owner_id";
	
	/**
	 * Registers a new owner ...
	 * @param $data The data
	 */
	public function create($data){
		unset($data["confirm_password"]);
		unset($data["accept"]);
		$data["hashcode"] = $this->getHashCode($data);
		$data["date_created"] = date("Y-m-d h:i:s");
		$data["date_updated"] = date("Y-m-d h:i:s");
		$data["password"] = md5($data["password"]);
		$this->insert($data);
		return $this->getAdapter()->lastInsertId($this->_name);	
	}
	
	
	/**
	 * Generate hash code ...
	 * @param $data The data
	 */
	private function getHashCode($data){
		return md5($data["username"].strtotime(date("Y-m-d h:i:s")));
	}
	
	/**
	 * List all owners ...
	 * @param $page - The page number
	 * @param $count - The number of count
	 * @param $detailed - Detailed view
	 */
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
	
	
	/**
	 * Check if user's email exist ...
	 * @param $email The email
	 */
	public function isEmailExist($email){
		$select = $this->select();
		return $this->fetchRow($select->where("email = ?", $email))!=null;
	}

	
	/**
	 * Check if user's username exist ...
	 * @param $username The username
	 */
	public function isUsernameExist($username){
		$select = $this->select();
		return $this->fetchRow($select->where("username = ?", $username))!=null;
	}
	
	/**
	 * Check if account has been activated ...
	 * @param $hashCode The hashcode
	 */
	public function isActivated($hashCode){
		$select = $this->select();
		$owner = $this->fetchRow($select->where("hashcode = ?", $hashCode));	
		return $owner->activated=="Y";
	}
	
	/**
	 * Activate Account ...
	 * @param $hashCode The Hashcode
	 */
	public function activateAccount($hashCode){
		$this->update(array("activated"=>"Y"), "hashcode = ".mysql_escape_string($hashCode));
	}
	
}
