<?php
class App_Agent extends AppModel{
	protected $_name = "agents";
	
	public function listQAs(){
		$agents = $this->fetchAll($this->select()->where("type = 'QA'"));
		if ($agents->count()>0){
			return $agents->toArray();
		}
		return array();
	}
	
	public function listAgents(){
		$agents = $this->fetchAll($this->select()->where("type = 'Agents'"));
		if ($agents->count()>0){
			return $agents->toArray();
		}
		return array();
	}
	
	
	public function listAll(){
		$agents = $this->fetchAll($this->select()->order("agent_id DESC"));
		if ($agents->count()>0){
			return $agents->toArray();
		}
		return array();
	}
}