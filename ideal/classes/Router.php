<?php
class Router extends Singleton{
    private $path_elements = array('controller','action','id');
	
	function parse($path){
		$request = $_REQUEST;

		$request['controller'] = app::gi()->config->default_controller;
		$request['action'] = app::gi()->config->default_action;
		$request['id'] = 0;
		$parts = parse_url($path);
		if (isset($parts['query']) and !empty($parts['query'])) {
			$path = str_replace('?'.$parts['query'], '', $path);
			parse_str($parts['query'], $req);
			$request = array_merge($request, $req);
		}
		foreach(app::gi()->config->router as $rule=>$keypath) {
			if (preg_match('#'.$rule.'#sui', $path, $list)) {
				for	($i=1; $i<count($list); $i=$i+1) {
					$keypath = preg_replace('#\$[a-z0-9]+#', $list[$i], $keypath, 1);
				}
				$keypath = explode('/', $keypath);
				foreach($keypath as $i=>$key) {
					$request[$this->path_elements[$i]] = $key;
				}
			}
		}

		return $request;
	}
	function test() {
		echo $path = '/user/',"\n";
		print_r($this->parse($path));
		echo $path = '/user/login/',"\n";
		print_r($this->parse($path));
		echo $path = '/user/profile/15',"\n";
		print_r($this->parse($path));
		echo $path = 'about.html',"\n";
		print_r($this->parse($path));
		echo $path = 'about.html?lenta=1#1',"\n";
		print_r($this->parse($path));
		exit();
	}
}