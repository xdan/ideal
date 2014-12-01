<?php
abstract class Singleton{
	private static $_aInstances = array();

	public static function getInstance( $className=false ) {
		$sClassName = ($className===false)?get_called_class():$className;

		if( class_exists($sClassName) ){
			if( !isset( self::$_aInstances[ $sClassName ] ) )
				self::$_aInstances[ $sClassName ] = new $sClassName();
			$oInstance = self::$_aInstances[ $sClassName ];
			return $oInstance; 
		}else
			throw new Except('Class '.$sClassName.'  no exist!');
	}
	public static function gI( $className=false ) {
		return self::getInstance($className);
	}
	final private function __clone(){}
	private function __construct(){}
}
