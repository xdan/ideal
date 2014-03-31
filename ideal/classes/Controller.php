<?php
class Controller extends Singleton{
	function __call( $methodName,$args=array() ){
		if( is_callable( array($this,$methodName) ) )
			return call_user_func_array(array($this,$methodName),$args);
		else
			throw new Except('In controller '.get_called_class().' method '.$methodName.' not found!');
	}
}