<?php
class UserController extends Controller{
	function index(){
		$model = new User();
		$this->render('index',array('model'=>$model));
	}
}