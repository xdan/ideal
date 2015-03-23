<?php
/**
 @name Database Wrapper for mysql
 @author Chupurnov Valeriy
 */
class db{
	private $connect_id = null;
	private $resource_id = null;
	private $sql = null;
	private $pfx = '';
	public $debug = true;
	
	function connect($config){
		$this->connect_id = mysql_connect($config['host'], $config['user'], $config['password']);
		if (!$this->connect_id) {
			$this->error();
			return false;
		}
		if (mysql_select_db($config['db'], $this->connect_id)) {
			if (!isset($config['charset'])) {
				$config['charset'] = 'utf8';
			}
			$this->query("SET NAMES '".$config['charset']."'")->
				query("SET CHARSET '".$config['charset']."'")->
				query("SET CHARACTER SET '".$config['charset']."'")->
				query("SET SESSION collation_connection = '".$config['charset']."_general_ci'");
		}
		if (isset($config['dbprefix'])) {
			$this->pfx = $config['dbprefix'];
		}
	}
	function last() {
		return $this->sql;
	}
	function res() {
		return $this->resource_id;
	}
	function query($sql) {
		$this->sql = preg_replace('@#__@u', $this->pfx, $sql);
		$this->resource_id = mysql_query($this->sql, $this->connect_id);
		if ($this->debug and !$this->resource_id) {
			$this->error();
		}
		return $this;
	}
	function row($field = false){
		if ($this->resource_id and $row = mysql_fetch_object($this->resource_id)) {
			return $field ? $row[$field] : $row;
		}
		return null;
	}
	function item($table, $where = '1', $fields = '*', $field = false){
		$item = $this->query('select '.$fields.' from '.$table.' where '.$where)->row($field);
		return $item; 
	}
	function items($table, $where = '1', $fields = '*', $field = false, $key = false){
		$items = $this->query('select '.$fields.' from '.$table.' where '.$where)->rows($field, $key);
		return $items; 
	}
	
	function rows($field = false, $key = false) {
		$rows = array();
		while($row = $this->row($field)) {
			if (!$key) {
				$rows[] = $row;
			} else {
				$rows[$row[$key]] = $row;
			}
		}
		return $rows;
	}
	function exists($table, $id, $field = 'id') {
		$pid = $this->query('select '.$field.' from '.$table.' where '.$field.'='.$this->__($id).' limit 1')->row($field);
		return $pid;
	}
	function cnt() {
		return mysql_affected_rows($this->connect_id);
	}
	private function _arrayKeysToSet($values){
		$ret='';
		if (is_array($values) or is_object($values)){
			foreach($values as $key=>$value){
			  if(!empty($ret))$ret.=',';
			  if (!is_numeric($key)) {
				$ret.="`$key`=".$this->__($value);
			  } else {
				$ret.=$value;
			  }
			}
		} else {
			$ret=$values;
		}
		return $ret;
	}
	function insert($table, $values){
		$ret = $this->_arrayKeysToSet($values);
		return $this->query('insert into '.$table.' set '.$ret);
	}
	function id(){
		return mysql_insert_id($this->connect_id);
	}
	public function update( $table, $values, $where=1 ){
		$ret = $this->_arrayKeysToSet($values);
		return $this->query('update '.$table.' set '.$ret.' where '.$where);
	}
	public function delete($table, $where){
		return $this->query('delete from '.$table.' where '.$where);
	}
	function _($value) {
		return mysql_real_escape_string($value, $this->connect_id);
	}
	function __($value) {
		return '"'.$this->_($value).'"';
	}
	
	public function error(){
		$langcharset = 'utf-8';
		echo "<HTML>\n";
		echo "<HEAD>\n";
		echo "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=".$langcharset."\">\n";
		echo "<TITLE>MySQL Debugging</TITLE>\n";
		echo "</HEAD>\n";
		echo "<div style=\"border:1px dotted #000000; font-size:11px; font-family:tahoma,verdana,arial; background-color:#f3f3f3; color:#A73C3C; margin:5px; padding:5px;\">";
		echo "<b><font style=\"color:#666666;\">MySQL Debugging</font></b><br /><br />";
		echo "<li><b>SQL.q :</b> <font style=\"color:#666666;\">".$this->sql."</font></li>";
		echo "<li><b>MySQL.e :</b> <font style=\"color:#666666;\">".mysql_error($this->connect_id)."</font></li>";
		echo "<li><b>MySQL.e.№ :</b> <font style=\"color:#666666;\">".mysql_errno($this->connect_id)."</font></li>";
		echo "<li><b>PHP.v :</b> <font style=\"color:#666666;\">".phpversion()."\n</font></li>";
		echo "<li><b>Data :</b> <font style=\"color:#666666;\">".date("d.m.Y H:i")."\n</font></li>";
		echo "<li><b>Script :</b> <font style=\"color:#666666;\">".getenv("REQUEST_URI")."</font></li>";
		echo "<li><b>Refer :</b> <font style=\"color:#666666;\">".getenv("HTTP_REFERER")."</li></div>";
		echo "</BODY>\n";
		echo "</HTML>";
		exit();
	}
}