<?php
class App extends Singleton{
	function start(){
		Router::gi()->parse();
		$controller = app::gi(Router::gi()->controller.'Controller');
		$controller->__call(Router::gi()->action);
	}
}