<?php
class App_Address extends AppModel{
	protected $_name = "addresses";
	
	public function getAddressByOwner($owner_id){
		$address = $this->fetchRow($this->getAdapter()->quoteInto("owner_id = ?", $owner_id));
		if (!is_null($address)){
			$address = $address->toArray();
			return $address[0];
		}else{
			return null;
		}
	}
}