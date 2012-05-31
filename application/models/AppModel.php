<?php 
abstract class AppModel extends Zend_Db_Table_Abstract{

	protected $_errors = array();
	protected $_validationSettings = array();
	
	
	/**
	 * Validate data from request object ...
	 * @param $validationSettings
	 */
	public function validateData($data, $validationSettings=array()){
		$valid = true;
		if (!empty($validationSettings)){
			$this->_validationSettings = $validationSettings;
		}
		foreach($this->_validationSettings as $validationSetting){
			$configs = $validationSetting["configs"];
			$field = $validationSetting["field"];
			$value = $data[$validationSetting["field"]];
			$valid = $this->performValidation($value, $configs);	
		}
		return $valid;
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

