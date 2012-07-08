<?php
class Mailer{
	public static function getTransport(){
		return new Zend_Mail_Transport_Smtp("p3smtpout.secureserver.net");
	}	
	public static function getTemplate($name, $vars=array()){
		$html = new Zend_View();
		$html->setScriptPath(APPLICATION_PATH . '/views/emaillayouts/');
		if (!empty($vars)){
			foreach($vars as $key=>$value){
				$html->assign($key, $value);
			}
		}
		return $html->render($name);
	}
}