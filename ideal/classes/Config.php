<?php
class Config extends Singleton{
	
	private $data = array();
	
	function associate( $group,&$array ){
		$this->data[$group] = $array;
	}
	
	function __get($name){
		return isset($this->data[$name])?$this->data[$name]:null;
	}
	
	function __set($name,$value){
		$this->data[$name] = $value;
	}
}