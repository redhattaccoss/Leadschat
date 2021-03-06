<?php 
class App_Owner extends AppModel{
	protected $_name = "owners";
	protected $_primary = "owner_id";
	
	
	private $addressModel = null;
	const PAYING_SERVICE_TYPE_PAY_AS_YOU_GO = "PAY AS YOU GO";
	const PAYING_SERVICE_TYPE_BULK_SUBSCRIBERS = "BULK SUBSCRIBERS";
	
	public function init(){
		parent::init();
		$this->addressModel = new App_Address();
	}
	
	/**
	 * Return the Address Model
	 * @return App_Address
	 */
	public function getAddressModel(){
		return $this->addressModel;
	}
	
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
		//$data["password"] = md5($data["password"]);
		$this->insert($data);
		return $this->getAdapter()->lastInsertId($this->_name);	
	}
	
	
	/**
	 * Generate hash code ...
	 * @param $data The data
	 */
	private function getHashCode($data){
		if (isset($data["username"])){
			return md5($data["username"].strtotime(date("Y-m-d h:i:s")));	
		}else{
			return false;
		}
	}
	
	/**
	 * List all owners ...
	 * @param $page The page number
	 * @param $count The number of count
	 * @param $detailed - Detailed view
	 */
	public function listAll($page, $count, $detailed = false){
		
		$select = $this->getAdapter()->select();
		
		$sql = $select->from($this->_name, array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS owner_id"), "first_name", "last_name", "website",
											  "company", "email", "username", 
											  "activated", "credits", "owner_type",
											  "timezone_id", "mobile",
											  "approved", "deleted", "fullname_webmaster",
											  "email_webmaster", "phone_webmaster",
											  "date_created", "date_updated"))
							  ->joinInner(array("no"=>"number_of_hits"), "no.id = owners.number_of_hit_id", array("no.name AS number_hits"))
							  ->order("date_created DESC");	  
		if ($page!=null&&$count!=null){
			$sql = $sql->limitPage($page, $count);
		}else{
			$sql = $sql->limitPage(1, 50);
		}
		$result = $this->getAdapter()->fetchAll($sql);	
		$appTimezone = new App_Timezone();
		
			foreach($result as $key=>$value){
				if ($detailed){
					try{
						$result[$key]["timezone"] = $appTimezone->find($value["timezone_id"])->getRow(0)->toArray();	
					}catch(Exception $e){
						$result[$key]["timezone"] = null;
					}
				}
				if ($result[$key]["approved"]=="Y"){
					$result[$key]["approved"] = 1;
				}else{
					$result[$key]["approved"] = 0;
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
	
	/**
	 * Generate a hashcode to be sent via email as per basis for setting new password
	 */
	public function forgotPassword($email){
		$select = $this->select();
		$owner = $this->fetchRow($select->from($this->_name, array("username"))->where("email = ?", $email))->toArray();
		$hashcode = $this->getHashCode($owner);
		if ($hashcode){
			$this->update(array("hashcode_reset"=>$hashcode), "owner_id = $owner_id");
			return $hashcode;			
		}else{
			return false;
		}
		
	}
	
	
	/**
	 * Reset password
	 * @param int $owner_id The owner
	 * @param string $newPassword The new password
	 * @return boolean
	 */
	public function resetPassword($owner_id, $newPassword){	
		$data["password"] = md5($newPassword);
		if ($owner_id){	
			$this->update($data, "owner_id = $owner_id");	
			return true;
		}else{
			return false;
		}
		
	}
	
	/**
	 * Approves an owner
	 * @param $owner_id
	 * @return boolean
	 */
	public function approve($owner_id){
		$data["approved"] = 1;
		$data["date_approved"] = date("Y-m-d h:i:s");
		$data["date_free_trial_expire"] = date("Y-m-d h:i:s", strtotime("+7 day", strtotime($data["date_approved"])));
		if ($owner_id){
			$this->update($data, "owner_id = ".$owner_id);
			return true;
		}else{
			return false;
		}
		
	}
	
	/**
	 * Disapproves an owner
	 * @param $owner_id
	 * @return boolean
	 */
	public function disapprove($owner_id){
		$data["approved"] = 0;
		$data["date_approved"] = null;
		$data["date_free_trial_expire"] = null;
		if ($owner_id){
			$this->update($data, "owner_id = ".$owner_id);
			return true;
		}else{
			return false;
		}
	
	}
	
	/**
	 * Checks if owner has sufficient credit
	 * @param $owner_id
	 * @return boolean
	 */
	public function hasSufficientCredit($owner_id){
		if ($owner_id){
			$owner = $this->find($owner_id);
			return $owner["credits"]>0;
		}else{
			return false;
		}
	}
	
	/**
	 * Returns true if owner is a Bulk Subscriber
	 * @param $owner_id - The owner
	 * @return boolean
	 */
	public function isBulkSubscriber($owner_id){
		if ($owner_id){
			$owner = $this->find($owner_id);
			return $owner["paying_service_type"]==self::PAYING_SERVICE_TYPE_BULK_SUBSCRIBERS;
		}else{
			return false;
		}
	}
	
	/**
	 * Returns true if owner is a Pay as you go 
	 * @param $owner_id The owner
	 * @return boolean
	 */
	public function isPayAsYouGo($owner_id){
		if ($owner_id){
			$owner = $this->find($owner_id);
			return $owner["paying_service_type"]==self::PAYING_SERVICE_TYPE_PAY_AS_YOU_GO;
		}else{
			return false;
		}
	}
	
	
	
	
	
}
