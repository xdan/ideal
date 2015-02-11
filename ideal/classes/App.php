<?php
class App extends Singleton{
    public $config = null;
    public $uri = null;
    function start(){
		$default_config = include IDEAL.'config.php';
		$custom_config = include APP.'config.php';
        $this->config = new Model(array_merge_recursive($default_config, $custom_config));

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
}
