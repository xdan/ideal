<?php
class router extends Singleton{
	public $action = 'index';
	public $controller = false;
	function parse(){
		if( isset($_REQUEST['controller']) )
			$this->controller = $_REQUEST['controller'];
		if( isset($_REQUEST['action']) )
			$this->action = $_REQUEST['action'];
	}
}
