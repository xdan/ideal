<?php
class UserController extends Controller{
	function actionIndex(){
		$model = new User();
		$this->render('index',array('model'=>$model));
	}
}