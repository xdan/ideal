<?php
class IndexController extends Controller{
	function actionIndex(){
		$model = new User();
		$this->render('index',array('model'=>$model));
	}
}