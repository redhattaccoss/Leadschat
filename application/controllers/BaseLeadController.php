<?php 
abstract class BaseLeadController extends Zend_Controller_Action{
	/**
	* @var Zend_Db_Adapter_Pdo_Mysql The database object
	 */
	protected $db;
	
	/**
	 * Ip Check Model ...
	 * @var Db_Ip
	 */
	protected $ipChecker;
	
	/**
	 * Auth Class ...
	 * @var Authentication
	 */
	protected $auth;
	
	
	/**
	 * Mailer object ...
	 * @var Zend_Mail
	 */
	protected $mailer;
	
	protected $baseUrl = "";
	
	public function init(){
		if (defined('RUNNING_FROM_ROOT')) {
			$this->baseUrl = "/public";
		}
		$db = new Db_Db();
		$this->db = $db->conn();
		$this->ipChecker = new Db_Ip($this->db);	
		$this->checkAdmin();
		$this->mailer = new Zend_Mail();
			
	}
	
	private function checkAdmin(){
		//check if there is an admin account
		$db = $this->db;
		$sql = $db->select()->from("agents")->where("username = 'admin'");
		$admin = $db->fetchRow($sql);
		if (!$admin){
			$newAdmin = array("first_name"=>"admin", 
							  "last_name"=>"admin",
							  "username"=>"admin",
							  "password"=>md5("admin"),
							  "type"=>"Admin");
			$db->insert("agents", $newAdmin);
		}
		$this->view->baseUrl = $this->baseUrl;
		$sql = $db->select()->from("agents")->where("username = 'mattyj'");
		$mattyj = $db->fetchRow($sql);
		if (!$mattyj){
			$mattyj = array("first_name"=>"Matthew", 
							  "last_name"=>"James",
							  "username"=>"mattyj",
							  "password"=>md5("admin"));
			$db->insert("agents", $mattyj);
		}
		$sql = $db->select()->from("agents")->where("username = 'allanaire'");
		
	}
	
	public function postDispatch(){
		parent::postDispatch();
		$this->getResponse()->setHeader("Cache-Control", "no-cache, must-revalidate");
		$this->view->baseUrl = $this->baseUrl;
	}
}

