<?php
class UserController extends Controller{
	function actionIndex(){
		$model = new User();
		$this->render('index',array('model'=>$model));
	}
	function actionLogin() {
		$user = new User();
		if (isset($_POST['login'])) {
			$user->login = $_POST['login'];
			$user->password = $_POST['password'];
			if ($user->auth) {
				header('Location:/'); //в случае успеха переходим на главную
				exit();
			} else {
				$this->error = 'Не верный пользователь или пароль';
			}
		}
		$this->render('login',array('model'=>$user));
	}
}