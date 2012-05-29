<?php 
class AuthFactory{
	public static $AGENT = 1;
	public static $OWNER = 2;
	public static function create($type, $db, $request=null){
		/**
		 * @var Authenticate
		 */
		$auth = null;
		if ($type==AuthFactory::$AGENT){	
			$auth = new Agent_Auth($db);
		}else if ($type==AuthFactory::$OWNER){
			$auth = new Owner_Auth($db);
		}
		if ($auth!=null){
			$auth->setRequestObject($request);
		}
		return $auth;
	}
}
	