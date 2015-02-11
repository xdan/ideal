<?php
class PageController extends Controller{
	function actionRead($id='index'){
		$this->render('read', array('id'=>$id));
	}
}