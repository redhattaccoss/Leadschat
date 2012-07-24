<?php 
class App_Lead extends AppModel{
	protected $_name = "leads";
	protected $_primary = "lead_id";
	
	/**
	 * @var App_Owner
	 */
	protected $ownerModel;

	/**
	 * @var App_Visitor
	 */
	protected $visitorModel;	

	
	/**
	 * @var App_ChatRequest
	 */
	protected $chatRequestModel;

	public function __construct(){
		$this->ownerModel = new App_Owner();
		$this->visitorModel = new App_Visitor();
		$this->chatRequestModel = new App_ChatRequest();
		parent::__construct();
	}
	
	
	/**
	 * Partially create a lead data
	 */
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
	
	/**
	 * Get All Leads On Database
	 */
	public function getAll($owner_id, $limit=false,$page=1, $records=10){
		$select = $this->select();
		$select->where("owner_id = ?", $owner_id)
				->order(array("date_updated DESC"));
		if ($limit){
			$select->limitPage($page, $records);
		}
	
		return $this->fetchAll($select)->toArray();
	}
	
	
	
	/**
	 * Cache lead on MongoDb
	 */
	public function cacheLead($lead_id){
		$select = $this->select();
		if ($lead_id){
			$select->where("lead_id = ?", $lead_id);
			$lead = $this->fetchRow($select);
			
			if ($lead){	
				$lead = $lead->toArray();
				$lead["owner"] = $this->ownerModel->find($lead["lead_id"])->toArray();
				$lead["chat_request"] = $this->chatRequestModel->getChatRequestForCaching($lead["chat_request_id"]);	
				try{
					$mongoDb = Db_Mongo::instantiate();
					$leadsCollection = $mongoDb->getCollection("leads_cached");
					$leadResult = $leadsCollection->findOne(array("lead_id"=>$lead["lead_id"]));
					if ($leadResult){
						$criteria = array("_id"=>new MongoId($leadResult["_id"]));
						$leadsCollection->update($criteria, $lead, array("upsert"=>true));
					}else{
						$leadsCollection->insert($lead);
					}
					return true;	
				}catch(Exception $e){
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	/**
	 * Expire all leads lower than 3 days
	 */
	public function expireLeads(){
		$select = $this->select();
		//load all non expire leads after 3 days of being created
		$leads = $this->fetchAll($select->from($this->_name, array("lead_id"))->where("expired = 0")->where("paid = 0")->where(new Zend_Db_Expr("(TO_DAYS(CURDATE()) - TO_DAYS(created)) > 3")))->toArray();
		try{
			$mongoDb = Db_Mongo::instantiate();
			$leadsCollection = $mongoDb->getCollection("leads_cached");
			return true;
		}catch(Exception $e){
			return false;
		}
		foreach($leads as $lead){
			$date = date("Y-m-d h:i:s");
			$this->update(array("expired"=>1, "expired_date"=>$date), "lead_id = {$lead["lead_id"]}");
			//update mongo db cached copy of lead
			$leadsCached = $leadsCollection->findOne(array("lead_id"=>$lead["lead_id"]));
			$leadsCached["expired"] = 1;
			$leadsCached["expired_date"] = new MongoDate(strtotime($date));
			$leadsCollection->save($leadsCached);
		}
	}
	
	public function getCachedLeadOnDate($owner_id, $date){
		try{
			$mongoDb = Db_Mongo::instantiate();
			$leadsCollection = $mongoDb->getCollection("leads_cached");
		}catch(Exception $e){
			return false;
		}
	}
	
	/**
	 * Cache Daily counters for newly delivered leads
	 */
	public function cacheDailyCounters($owner_id){
		$select = $this->select();
		try{
			$mongoDb = Db_Mongo::instantiate();
			$ownersCollection = $mongoDb->getCollection("daily_counters_owners");
			$counters = $ownersCollection->find(array("owner_id"=>$owner_id));
			$counters = iterator_to_array($counters);
			if (empty($counters)){
				$select = $this->select();
				$dates = $this->fetchAll($select->distinct()->from($this->_name, array("created"))->where("owner_id = ?", $owner_id)->where("paid = ?", 0))->toArray();
				foreach($dates as $date){
					$count = $this->fetchRow($select->from($this->_name,
														 array(new Zend_Db_Expr("COUNT(lead_id) AS count")))
											->where("owner_id = ?", $owner_id))
											->where("DATE(created) = DATE(?)", $date["created"])
											->save("paid = 0")->toArray();
					$counter = array("owner_id"=>$owner_id, "created"=>new MongoDate(strtotime($date["created"])), "count"=>$count["count"]);
					$ownersCollection->insert($counter);	
				}
				$counters = $ownersCollection->find(array("owner_id"=>$owner_id));
				$counters = iterator_to_array($counters);	
			}
			return $counters;
		}catch(Exception $e){
			return false;
		}
	}

	/**
	 * Get Cache Leads Daily Counter from specified date
	 * @param owner_id The owner id
	 * @param date_from The date from
	 * @param date_to The date to
	 */
	public function getCacheLeadsDailyCounter($owner_id, $date_from, $date_to){
		try{
			
			$mongoDb = Db_Mongo::instantiate();
			$ownersCollection = $mongoDb->getCollection("daily_counters_owners");
			$counters = $ownersCollection->find(array("created"=>array('$gte'=>new MongoDate(strtotime($date_from)), 'lte'=>new MongoDate(strtotime($date_to))), 
												"paid"=>0));
			$counters = iterator_to_array($counters);
			if (empty($counters)){
				$this->cacheDailyCounters($owner_id);
				$counters = $ownersCollection->find(array("created"=>array('$gte'=>new MongoDate(strtotime($date_from)), 'lte'=>new MongoDate(strtotime($date_to)))
													, "paid"=>0));
				$counters = iterator_to_array($counters);
			}
			return $counters;
		}catch(Exception $e){
			return false;
		}
	}
	

	public function getReadyToBuyLeads($date,$owner_id){
		$select = $this->select();
		$leads = $this->fetchAll($select->from($this->_name, array("created", "lead_id"))
								->where("DATE(created) = ?", $date)
								->where("owner_id = ?", $owner_id)
								->where("expired = 0"))->toArray();
		return $leads;
	}
	
	
	
}