<?php
class App extends Singleton{
    public $config = null;
    public $uri = null;
	public function __construct(){
		$this->initSystemHandlers();
		$default_config = include IDEAL.'config.php';
		$custom_config = include APP.'config.php';
        $this->config = new Model(array_merge($default_config, $custom_config));
	}
    function start(){
		$this->uri = new Model(Router::gi()->parse($_SERVER['REQUEST_URI']));
        $controller = app::gi($this->uri->controller.'Controller');
		ob_start();
		$controller->__call('action'.$this->uri->action, array($this->uri->id));
		$content = ob_get_clean();
        if ($this->config->scripts and is_array($this->config->scripts)) {
			foreach ($this->config->scripts as $script) {
				$controller->addScript($script);
			}
		}
		if ($this->config->styles and is_array($this->config->styles)) {
			foreach ($this->config->styles as $style) {
				$controller->addStyleSheet($style);
			}
		}
		$controller->renderPage($content);
    }
	protected function initSystemHandlers() {
		set_exception_handler(array($this,'handleException'));
		set_error_handler(array($this,'handleError'),error_reporting());
	}
	public function handleError($code,$message,$file,$line) {
		if($code & error_reporting()) {
			restore_error_handler();
			restore_exception_handler();
			try{
				$this->displayError($code,$message,$file,$line);
			} catch(Exception $e) {
				$this->displayException($e);
			}
		}
	}
	public function handleException($exception){
		restore_error_handler();
		restore_exception_handler();
		$this->displayException($exception);
	}
	public function displayError($code,$message,$file,$line){
		echo "<h1>PHP Error [$code]</h1>\n";
		echo "<p>$message ($file:$line)</p>\n";
		echo '<pre>';

		$trace=debug_backtrace();

		if(count($trace)>3)
			$trace=array_slice($trace,3);
		
		foreach($trace as $i=>$t){
			if(!isset($t['file']))
				$t['file']='unknown';
			if(!isset($t['line']))
				$t['line']=0;
			if(!isset($t['function']))
				$t['function']='unknown';
			echo "#$i {$t['file']}({$t['line']}): ";
			if(isset($t['object']) && is_object($t['object']))
				echo get_class($t['object']).'->';
			echo "{$t['function']}()\n";
		}

		echo '</pre>';
		exit();
	}
	public function displayException($exception) {
		echo '<h1>'.get_class($exception)."</h1>\n";
		echo '<p>'.$exception->getMessage().' ('.$exception->getFile().':'.$exception->getLine().')</p>';
		echo '<pre>'.$exception->getTraceAsString().'</pre>';
	}
}
