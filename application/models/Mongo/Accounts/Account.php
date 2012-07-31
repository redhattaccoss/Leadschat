<?php
class Mongo_Accounts_Account{
	
	/**
	 * The QA
	 * @var array
	 */
	private $assignedQA;
	
	/**
	 * The Owner 
	 * @var array 
	 */
	private $owner;
	
	
	/**
	 * 
	 * The assigned agent in serving for the owner
	 * @var array
	 */
	private $assignedAgents;
	/**
	 * @return the $assignedQA
	 */
	public function getAssignedQA() {
		return $this->assignedQA;
	}

	/**
	 * @return the $owner
	 */
	public function getOwner() {
		return $this->owner;
	}

	/**
	 * @param multitype: $assignedQA
	 */
	public function setAssignedQA($assignedQA) {
		$this->assignedQA = $assignedQA;
	}

	/**
	 * @param multitype: $owner
	 */
	public function setOwner($owner) {
		$this->owner = $owner;
	}
	
	
	public function addAgent($agent){
		$this->assignedAgents[] = $agent;
	}
	
	public function getAgents(){
		return $this->assignedAgents;
	}
	
	public function toArray(){
		return array("qa"=>$this->assignedQA, "owner"=>$this->owner, "assignedAgents"=>$this->assignedAgents);
	}

	
	
}