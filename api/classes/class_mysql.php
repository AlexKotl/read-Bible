<?php

class CMysql {
	private $script_time, $debug_mode = true;
	public $table_name, $link;

   // connect to database
   function CMysql($params=array()) {
   	   include __DIR__ . "/../db_config.php";

	   $this->link = mysqli_connect($db_server,$db_user,$db_password,$db_name) or die("Cannot connect to Mysqli DB $db_server:$db_user");
	   $this->table_name = $db_name;
	   mysqli_set_charset($this->link, 'utf8');
   }

   function query($string, $return_array=false) {
        global $db; // if calling statically - try to use global object for DB queries

        if ($return_array==='debug') {
            echo $string; return true;
        }

        $start_time = microtime(true);

        if (isset($this)) {
            if (get_class($this)=='CMysql' && isset($this->link)) {
                $result = mysqli_query($this->link, $string);
            }
            else {
                $result = $db->query($string);
            }
        }
        else {
            $result = $db->query($string);
        }
        $end_time = microtime(true);

        if (DEBUG_MODE===true && ($end_time - $start_time)*100>5) {
            $info = debug_backtrace();
            $stack_num = 0;
            while ($info[$stack_num][file]==__FILE__) $stack_num++;
            echo "<li>Query too slow (".round(($end_time - $start_time)*100,2)." ms): $string (Line ".$info[$stack_num][line]." in ".basename($info[$stack_num][file]).")";
        }

        if ($result===false) return false;

        if ($return_array===true) {
            $arr = array();
            while ($row=mysqli_fetch_array($result)) {
                array_push($arr,$row);
            }
            $result = $arr;
        }
        return $result;
   }

   function fetch(&$res) {
		return mysqli_fetch_assoc($res);
   }

   function fetch_assoc(&$res){
      return mysqli_fetch_assoc($res);
   }

   function num_rows(&$res) {
	   return mysqli_num_rows($res);
   }

   function escape($string) {
	   return mysqli_real_escape_string($this->link, $string);
   }

   function set_charset($charset) {
	   return mysqli_set_charset($this->link, $charset);
   }

   function error() {
	   global $db;
	   if (isset($db)) return mysqli_error($db->link);
   }

   function get_row($string) {
      if (isset($this)) {
      	if (get_class($this)=='CMysql' && isset($this->link)) {  $res = $this->query($string, $this->link); }
      	else $res = self::query($string);
      }
      else { $res = self::query($string); }

      if ($res===false) return false;
      if (mysqli_num_rows($res)==0) return false;
      $row = mysqli_fetch_array($res);
      if (count($row)==2) return $row[0];
      else return $row;
   }

	function filter ($str, $rule = '') {
		if ($rule == 'email')
			return preg_replace("/([^a-zA-Z0-9@_\.\-])/","", $str);

		$str = addslashes($str);

		return $str;
	}

   function last_insert_id($table = '') {
        return mysqli_insert_id($this->link);
   }

   function insert($table, $vars, $debug='') {
   	$name_arr = $value_arr = array();
   	foreach ($vars as $k=>$v) {
   		if (is_int($k)) {
   		   if ($_GLOBAL[$v]=='') $_GLOBAL[$v] = $_POST[$v];
   			array_push($name_arr,'`'.$v.'`');
   			array_push($value_arr,'"'.$_GLOBAL[$v].'"');
   		}
   		else {
   			array_push($name_arr,'`'.$k.'`');
   			if ($v=='now()') array_push($value_arr,$v);
   			else array_push($value_arr,'"'.$v.'"');
   		}
   	}
   	$res = self::query("insert into $table (".implode(',',$name_arr).") values (".implode(', ',$value_arr).")", $debug);
   	if (!$res) return false;
   	else return true;
   }

   function update($table, $id, $vars, $debug='') {

	   if (strpos($id, "=") !== false) {
		   list($field_id, $id) = explode("=", $id);
	   }
	   else $field_id = "id";

   	$id = (int)$id;
   	if ($id==0) return false;
   	//$name_arr = $value_arr = array();
   	$query_str = '';
   	$is_first = true;
   	foreach ($vars as $k=>$v) {
   		if (!$is_first) $query_str .= ", ";
   		if (is_int($k)) {
   		   if ($_GLOBAL[$v]=='') $_GLOBAL[$v] = $_POST[$v];
   		   $query_str .= " `$v` = \"".$_GLOBAL[$v].'"';
   		}
   		else {
   			$query_str .= " `$k` = \"$v\"";
   		}
   		$is_first = false;
   	}
   	$res = self::query("update {$table} set {$query_str} where {$field_id}='{$id}'", $debug);
   	if (!$res) return mysqli_error($res);
   	else return true;
   }

   function start_time() {
   	$this->script_time = microtime(true);
   }
   function end_time($display=true) {
   	$delta = microtime(true) - $this->script_time;
   	if ($display) echo "<li>Time: ".round($delta*100,1).' ms';
   	return $delta;
   }

}

?>
