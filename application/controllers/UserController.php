<?php
class UserController extends Controller{
	function index(){
		$model = new User();
		include ROOT.'application/views/user/index.php';
	}
}