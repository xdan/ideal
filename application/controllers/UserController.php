<?php
class UserController extends Controller{
	function actionIndex(){
		$model = new User();
		$this->render('login',array('model'=>$model));
	}
}