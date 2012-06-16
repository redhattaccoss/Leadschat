<?php 

class MailerTemplates{
	public static function getTemplate($name){
		$layout = new Zend_Layout();
		$layout->setLayoutPath(APPLICATION_PATH.DIRECTORY_SEPARATOR."views/emaillayouts");
		$layout->setLayout($name);
		return 	$layout;	
	}
}