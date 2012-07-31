<?php
class Mongo_Account_Model extends Mongo_Model{
	public function __construct(){
		parent::__construct();
		$this->_collectionName = "accounts";
	}
	
}