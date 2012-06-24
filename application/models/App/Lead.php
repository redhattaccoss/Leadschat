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
	
	public function getAll($owner_id, $limit=false,$page=1, $records=10){
		$select = $this->select();
		$select->where("owner_id = ?", $owner_id)
				->order(array("date_updated DESC"));
		if ($limit){
			$select->limitPage($page, $records);
		}
	
		return $this->fetchAll($select)->toArray();
	}
	
	public function cacheLead($lead_id){
		$select = $this->select();
		$select->where("lead_id = ?", $lead_id);
		$lead = $this->fetchRow($select)->toArray();	
		$lead["owner"] = $this->ownerModel->find($lead["lead_id"])->toArray();
		$lead["visitor"] = $this->visitorModel->find($lead["visitor_id"])->toArray(); 
		$lead["chat_request"] = $this->chatRequestModel->getChatRequestForCaching($lead["chat_request_id"]);	
		try{
			$mongoDb = Db_Mongo::instantiate();
			$leads = $mongoDb->getCollection("leads_cached");
			$leads->insert($lead);
			return true;	
		}catch(Exception $e){
			return false;
		}
	}
	
	public function getAggregatedLeadsCount($owner_id, $days_from_today=3){
		$select = $this->select();
		$select->from($this->_name, array(new Zend_Db_Expr("")))->where("owner_id = ?", $owner_id)
				->order(array("date_updated DESC"))
				->limitPage($page, $records);
		return $this->fetchAll($select)->toArray();
	}
}