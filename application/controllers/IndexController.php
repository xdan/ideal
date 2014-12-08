<?php
class IndexController extends Controller{
	function index(){
		$model = new User();
		$this->render('index',array('model'=>$model));
	}
}