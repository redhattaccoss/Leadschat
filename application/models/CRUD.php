<?php
interface CRUD{
	public function create($request=null);
	public function update($request=null);
	public function delete($request=null);
	public function read($condition=array());
}