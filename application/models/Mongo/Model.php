<?php
abstract class Mongo_Model{
	protected $_collectionName;
	protected $_mongoDb;

	public function __construct(){
		try{
			$this->_mongoDb = Db_Mongo::instantiate();
		}catch(Exception $e){
			
		}
	}
	
	public function getCollection(){
		try{
			return $this->_mongoDb->getCollection($this->_collectionName);
		}catch(Exception $e){
			return null;
		}
	}
}