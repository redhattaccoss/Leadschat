<?php 
class Db_Ip extends BaseModel{

	public function isIpBlocked(){
		$db = $this->db;
		$ip = ip2long($_SERVER["REMOTE_ADDR"]);
        //perform ip block check
        $sql = $db->select()
        		->from("ip_blocks", array("ip_address"))
        		->where("ip_address = ?", $ip);
        $ip = $db->fetchRow($sql);
        return $ip!=null;
	}
}