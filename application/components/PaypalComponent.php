<?php
class PaypalComponent{
	/**
	 * The Username
	 * @var String
	 */
	private $API_UserName;
	
	/**
	 * The password
	 * @var String
	 */
	private $API_Password;
	
	/**
	 * API signature
	 * @var String
	 */
	private $API_Signature;
	
	/**
	 * Gateway to access payment gateway
	 * @var String
	 */
	private $API_Endpoint;
	
	
	/**
	 * The environment
	 * @var String
	 */
	private $environment;
	
	
	/**
	 * The version
	 * @var String
	 */
	private $version;
	public function __construct(){
		$environment = "sandbox";
		$this->API_UserName = urlencode('my_api_username');
		$this->API_Password = urlencode('my_api_password');
		$this->API_Signature = urlencode('my_api_signature');
		$this->API_Endpoint = "https://api-3t.paypal.com/nvp";
		if("sandbox" === $environment || "beta-sandbox" === $environment) {
			$API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
		}
		$this->version = urlencode('51.0');
	}
}