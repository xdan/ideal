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
		$content = $this->renderPartial($filename,$variables,false);
		return $this->_renderPartial($this->tplPath.'main.php',array_merge(array('content'=>$content),$variables),$output);
	}	
}
