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
	
	/**
	 * The error from validation ...
	 * @var 
	 */
	protected $_errors = array();
	
	/**
	 * The validation settings array ...
	 * @var 
	 */
	protected $_validationSettings = array();
	
	/**
	 * The fields to be not included for saving ...
	 * @var Array
	 */
	protected $_skipFields = array();
	
	/**
	 * The table for a model ...
	 * @var String
	 */
	protected $_table = "";
	
	
	public function __construct($db){
		$this->db = $db;
	}
	
	/**
	 * Non constructor start of a model ...
	 */
	public function init(){
		
	}
	
	/**
	 * set the request object ...
	 * @param $request
	 */
	public function setRequestObject($request){
		$this->_request = $request;		
	}
	
	/**
	 * Get post data in a form of array ...
	 */
	public function getPostData(){
		$data = array();
		foreach($_POST as $key=>$value){
			if (!in_array($key, $this->_skipFields)){
				$data[$key] = $this->_request->getPost($key);	
			}					
		}
		return $data;
	}
	
	/**
	 * Set validation settings ...
	 * @param $validationSettings
	 */
	public function setValidationSettings($validationSettings){
		$this->_validationSettings = $validationSettings;
	}
	
	/**
	 * Validate a key pair array ...
	 * @param $data The data to be validate
	 * @param $validationSettings Validation settings passed on the fly
	 */
	public function validateData($data, $validationSettings=array()){
		$valid = true;
		$errors = array();
		if (!empty($validationSettings)){
			$this->_validationSettings = $validationSettings;
		}
		foreach($this->_validationSettings as $validationSetting){
			$configs = $validationSetting["configs"];
			$field = $validationSetting["field"];
			
		
		
		}
	}
	
	/**
	 * Perform validation on the background ...
	 * @param $value The value to validate
	 * @param $configs Configs loaded
	 */
	private function performValidation($value, $configs){
		$errors = array();
		$valid = true;
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
		$this->_errors = $errors;
		return $valid;
	}
	
	
	/**
	 * Validate data from request object ...
	 * @param $validationSettings
	 */
	public function validate($validationSettings=array()){
		$valid = true;
		if (!empty($validationSettings)){
			$this->_validationSettings = $validationSettings;
		}
		foreach($this->_validationSettings as $validationSetting){
			$configs = $validationSetting["configs"];
			$field = $validationSetting["field"];
			$value = $this->_request->getParam($validationSetting["field"]);
			$valid = $this->performValidation($value, $configs);	
		}
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
