<?php
class Registry{
	private $data = array();
    function __construct($data = array()) {
	   $this->data = $data;
    }
	function __get($name){
		return isset($this->data[$name])?$this->data[$name]:null;
	}
	function __set($name,$value){
		$this->data[$name] = $value;
	}
}
