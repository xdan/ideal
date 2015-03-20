<?php
class PostController extends Controller{
	function actionIndex() {
		$posts = Post::models();
		$this->render('index',array('items'=>$posts));
	}
	function actionRead() {
		$post = new Post();
		$posts = $post->models();
		$this->render('index',array('items'=>$post));
	}
	function actionCreate() {
		$post = new Post();
		if (isset($_POST['form'])) {
			$post->__attributes = $_POST['form'];
			if ($post->save()) {
				header('location:/post/index');
				exit();
			}
		}
		$this->render('form',array('item'=>$post));
	}
	function actionUpdate($id) {
		$id = (int)$id ? (int)$id : (int)$_POST['form']['id'];
		$post = Post::model($id);
		if ($post->id) {
			if (isset($_POST['form'])) {
				$post->__attributes = $_POST['form'];
				if ($post->save()) {
					header('location:/post/index');
					exit();
				}
			}
			$this->render('form',array('item'=>$post));
		} else {
			throw new Except('Запись не найдена');
		}
	}
}