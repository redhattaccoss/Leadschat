<?php 
class BaseModel{
	/**
	* @var Zend_Db_Adapter_Pdo_Mysql The database object
	 */
	protected $db;	
	/**
	 * The request object ...
	 * @var Zend_Controller_Request_Abstract
	 */
	protected $_request;
	
	protected $_errors = array();
	
	protected $_validationSettings = array();
	
	protected $_skipFields = array();
	
	public function __construct($db){
		$this->db = $db;
	}
	
	public function setRequestObject($request){
		$this->_request = $request;		
	}
	
	public function getPostData(){
		$data = array();
		foreach($_POST as $key=>$value){
			if (!in_array($key, $this->_skipFields)){
				$data[$key] = $this->_request->getPost($key);	
			}					
		}
		return $data;
	}
	
	public function setValidationSettings($validationSettings){
		$this->_validationSettings = $validationSettings;
	}
	
	public function validate($validationSettings=array()){
		$valid = true;
		$errors = array();
		if (!empty($validationSettings)){
			$this->_validationSettings = $validationSettings;
		}
		foreach($this->_validationSettings as $validationSetting){
			$configs = $validationSetting["configs"];
			$field = $validationSetting["field"];
			$value = $this->_request->getParam($validationSetting["field"]);
			foreach($configs as $config){
				$validation = $config["validation"];
				if ($validation=="required"){
					if ($this->requireValidate($value)){
						$valid = false;
						if (isset($config["errorMessage"])){
							$errors[] = $config["errorMessage"];	
						}else{
							$errors[] = $validationSetting["field"]." is required.";
						}
					}
				}else if ($validation=="min"){
					if ($this->minimalValidate($value, $validationSetting["setting"])){
						$valid = false;
						if (isset($config["errorMessage"])){
							$errors[] = $config["errorMessage"];	
						}else{
							$errors[] = $validationSetting["field"]." requires a minimum of {$validationSetting["setting"]["length"]}.";
						}
					}
				}else if ($validation=="exist"){
					if ($this->existOnDbValidate($value, $field, $validationSetting["setting"]["table"])){
						$valid = false;
						if (isset($config["errorMessage"])){
							$errors[] = $config["errorMessage"];	
						}else{
							$errors[] = $value." already exists.";
						}
					}
				}
			}
		}
		
		$this->_errors = $errors;
		return $valid;
	}
	
	public function getErrors(){
		return $this->_errors;
	}
	
	private function requireValidate($value){
		return trim($value)=="";
	}
	
	private function minimalValidate($value, $setting){
		if (isset($setting["length"])){
			$length = $setting["length"];
			$validator = new Zend_Validate_StringLength();
			$validator->setMin($min);
			return !$validator->isValid($value);
		}else{
			return false;
		}
		
	}
	
	private function existOnDbValidate($value, $field, $table){
		 $validator = new Zend_Validate_Db_RecordExists(array("field"=>$field, "table"=>$table));
		 return !$validator->isValid($value);
	}
}
