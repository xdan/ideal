<?php
function class_autoload($class_name) {
	$file = IDEAL . 'classes/'.ucfirst(strtolower($class_name)).'.php';
	if( file_exists($file) == false )
		return false;
	require_once ($file);
}
function controller_autoload($class_name) {
	$file = APP . 'controllers/'.preg_replace('#controller$#i', 'Controller', ucfirst(strtolower($class_name))).'.php';
	if( file_exists($file) == false )
		return false;
	require_once ($file);
}
function model_autoload($class_name) {
	$file = APP . 'models/'.ucfirst(strtolower($class_name)).'.php';
	if( file_exists($file) == false )
		return false;
	require_once ($file);
}

spl_autoload_register('class_autoload');
spl_autoload_register('controller_autoload');
spl_autoload_register('model_autoload');
