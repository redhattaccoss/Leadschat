<?php 
interface Authentication{
	public function authenticate();
	public function setRequestObject($request);
	public function isAuthenticated();
	public function logout();
}