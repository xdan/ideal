<?php
class Model{
	private $data = array();
	function __get($name){
		return isset($this->data[$name])?$this->data[$name]:null;
	}
	function __set($name,$value){
		$this->data[$name] = $value;
	}
}