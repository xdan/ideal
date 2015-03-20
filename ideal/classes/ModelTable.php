<?php
abstract class ModelTable extends Model{
	public $errors = array();
	static public $table = '{table}';
	static public $primary = 'id';
	
	function beforeSave () {
		return !count($this->errors);
	}

	function save () {
		$modelname = get_called_class();
		if ($this->beforeSave()) {
			if (!$this->__get(self::$primary)) {
				$res = App::gi()->db->insert($modelname::$table, $this->_data);
				$this->__set($modelname::$primary, App::gi()->db->id());
				return $res;
			} else {
				return App::gi()->db->update($modelname::$table, $this->_data, $modelname::$primary.'='.$this->__get(self::$primary));
			}
		}
	}
	static function getQuery() {
		$modelname = get_called_class();
		return 'select * from '.$modelname::$table;
	}
	static function models() {
		$items = App::gi()->db->query(self::getQuery())->rows();
		$results = array();
		$modelname = get_called_class();
		foreach ($items as $item) {
			$model = new $modelname();
			$model->__attributes = $item;
			$results[] = $model;
		}
		return $results;
	}
	static function model($id) {
		$modelname = get_called_class();
		$item = App::gi()->db->query('select * from '.$modelname::$table.' where '.$modelname::$primary.'='.App::gi()->db->_($id))->row();
		$model = new $modelname();
		$model->__attributes = $item;
		return $model;
	}
}