<?php
interface Mongo_Logs_Log{
	const IMPORTANT = 1;
	const NOTIFICATION = 2;
	const SYSTEM_LOG = 3;
	
	public function getLog($data);
}