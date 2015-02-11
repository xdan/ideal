<?php
class Controller extends Singleton{
	function __call($methodName, $args=array()){
		if (method_exists($this, $methodName))
			return call_user_func_array(array($this,$methodName),$args);
		else
			throw new Except('In controller '.get_called_class().' method '.$methodName.' not found!');
	}
	
	public $tplPath = '';
	public $tplControllerPath = '';
	
	function __construct(){
		$this->tplPath = APP.'views/';
		$this->tplControllerPath = APP.'views/'.strtolower(str_replace('Controller','',get_called_class())).'/';
	}
	
	private function _renderPartial($fullpath,$variables=array(),$output=true){
		extract($variables);
		
		if( file_exists($fullpath) ){
			if( !$output )
				ob_start();
			include $fullpath;
			return !$output?ob_get_clean():true;
		}else	
			throw new Except('File '.$fullpath.' not found');
		
	}
	/**
	 * renderPartial - methods are available in the controller to display the template file. 
	 * Does not run any more files. Convenient when ajax call controller
	 *
	 * @params $filename - template name in the folder views / controller name / {}. php
	 * @params $variables -array keys will be available in the template as variables 
	 * The same name
	 * @params $output - If you specify false, the data from the template will be displayed in the main stream and will be returned by
	 */
	public function renderPartial($filename,$variables=array(),$output=true){
		$file = $this->tplControllerPath.str_replace('..','',$filename).'.php';
		return $this->_renderPartial($file,$variables,$output);
	}
	
	/**
	 * render - method performs the complete withdrawal of the page to the screen. Thus, it includes 
	 * The contents of the template file $ filename
	 *
	 * @params - All parameters are identical renderPartial
	 */
	public function render($filename,$variables=array(),$output=true){
		$this->renderPartial($filename, $variables, $output);
	}
	
	/**
	 * render - метод рендерит конечную страницу, которая будет выдана в браузер
	 */
	public function renderPage($content){
		$html = $this->_renderPartial($this->tplPath.'main.php',array('content'=>$content), false);
		$output = array('head'=>'','body'=>'');
		foreach ($this->assets as $item) {
			if ($item['asset'] == 'script') {
				if ($item['type']=='inline') {
					$output[$item['where']].='<script type="text/javascript">'.$item['data'].'</script>'."\n";
				} else {
					$output[$item['where']].='<script type="text/javascript" src="'.$item['data'].'"></script>'."\n";
				}
			}else{
				if ($item['type']=='inline') {
					$output[$item['where']].='<style>'.$item['data'].'</style>'."\n";
				} else {
					$output[$item['where']].='<link rel="stylesheet" href="'.$item['data'].'" type="text/css" />'."\n";
				}
			}
		}
		if ($output['head']) {
			$html = preg_replace('#(<\/head>)#iu', $output['head'].'$1', $html);
		}
		if ($output['body']) {
			$html = preg_replace('#(<\/body>)#iu', $output['body'].'$1', $html);
		}

		echo $html;
	}
	
	private $assets = array();
	
	private function addAsset($link, $where = 'head', $asset = 'script', $type = 'url'){
		$hash = md5('addScript'.$link.$where.$asset.$type);
		$where = $where=='head' ? 'head' : 'body';
		$asset = $asset=='script' ? 'script' : 'style';
		if (!isset($this->assets[$hash])) {
			$this->assets[$hash] = array('where'=>$where,'asset'=>$asset,'type'=>$type,'data'=>$link);
		}
	}
	public function addScript($link, $where = 'head'){
		$this->addAsset($link, $where);
	}
	public function addStyleSheet($link, $where = 'head'){
		$this->addAsset($link, $where, 'style');
	}
	public function addScriptDeclaration($data, $where = 'head'){
		$this->addAsset($data, $where, 'script', 'inline');
	}
	public function addStyleSheetDeclaration($data, $where = 'head'){
		$this->addAsset($data, $where, 'style', 'inline');
	}
}
