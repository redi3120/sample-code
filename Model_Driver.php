<?php
class Model_Driver {
	static $instance;
	public $ins_db;

	static function get_instance() {
		if(self::$instance instanceof self) {
			return self::$instance;
		}
		return self::$instance = new self;
	}

	public function __construct() {
		$this->ins_db = new mysqli(HOST,USER,PASSWORD,DB_NAME);
		if($this->ins_db->connect_error) {
			throw new DbException(ERR_S.$this->ins_db->connect_errno.'|'.iconv('CP1251','UTF-8',$this->ins_db->connect_error));
		}
		
		$this->ins_db->query("SET NAMES 'UTF8'");
	}

	public function select(
		$param,
		$table,
		$where = array(),
		$order = false,
		$napr = 'ASC',
		$limit = false,
		$operand = arraY('='),
		$match = array()
	) {
		$sql = 'SELECT';

		foreach($param as $item) {$sql .= ' '.$item.',';}

		$sql = rtrim($sql,',');
		$sql .= ' '.'FROM'.' '.$table;

		if(count($where) > 0) {
			$ii = 0;
			foreach($where as $key=>$val) {
				if($ii == 0) {
					if($operand[$ii] == 'IN') {
						$sql.= ' WHERE '.strtolower($key).' '.$operand[$ii].'('.$val.')';
					} else {
						$sql .= ' '.' WHERE '.strtolower($key).' '.$operand[$ii].' '."'".$this->ins_db->real_escape_string($val)."'";
					}
				}
				if($ii > 0) {
					if($operand[$ii] == 'IN') {
						$sql.= ' AND '.strtolower($key).' '.$operand[$ii].'('.$val.')';
					} else {
						$sql .= ' '.' AND '.strtolower($key).' '.$operand[$ii].' '."'".$this->ins_db->real_escape_string($val)."'";
					}
				}
				$ii++;
				if((count($operand) -1) < $ii) { $operand[$ii] = $operand[$ii-1]; }
			}
		}
		
		if(count($match) > 0) {
			foreach($match as $k=>$v) {
				if(count($where) > 0) {
					$sql.= " AND MATCH (".$k.") AGAINST('".$this->ins_db->real_escape_string($v)."')";
				} elseif(count($where)  == 0) {
					$sql.= " WHERE MATCH (".$k.") AGAINST('".$this->ins_db->real_escape_string($v)."')";
				}
			}
		}
		
		if($order) { $sql .= ' ORDER BY '.$order.' '.$napr.' '; }
		if($limit) { $sql .= ' LIMIT '.$limit; } 
		$result = $this->ins_db->query($sql);
		if(!$result) {echo ERR;}
		if($result->num_rows == 0) {return false;}
		for($i = 0; $i < $result->num_rows; $i++) {
			$row[] = $result->fetch_assoc();
		}
		return $row;				
	}

	public function delete($table,$where = array(),$operand = array('=')) {
		$sql = 'DELETE FROM '.$table;
		if(is_array($where)) {
			$i = 0;
			foreach($where as $k=>$v) {
				$sql .= ' WHERE '.$k.$operand[$i]."'".$v."'";
				$i++;
				if((count($operand) -1) < $i) {$operand[$i] = $operand[$i-1];}
			}
		}

		$result = $this->ins_db->query($sql);
		if(!$result) {echo ERR;}
		return true;
	}

	public function insert($table, $data = array(),$values = array(),$id = false) {
		$sql = 'INSERT INTO '.$table." (";
		$sql .= implode(',',$data).") ";
		$sql .= 'VALUES (';

		foreach($values as $val) {$sql .= "'".$val."'".",";}

		$sql = rtrim($sql,',').")";
		$result = $this->ins_db->query($sql);

		if(!$result) {echo ERR;}

		if($id) {return $this->ins_db->insert_id;}
		return true;
	}

	public function update($table,$data = array(),$values = array(),$where = array()) {
		$data_res = array_combine($data,$values);
		$sql = 'UPDATE '.$table.' SET ';

		foreach($data_res as $key=>$val) {$sql .= $key."='".$val."',";}

		$sql = rtrim($sql,',');

		foreach($where as $k=>$v) {
			$sql .= ' WHERE '.$k.'='."'".$v."'";
		}
		$result = $this->ins_db->query($sql);

		if(!$result) {echo ERR;}
		return true;
	}

	public function quote(){
		$sql = 'SELECT `text`, `author` FROM quote ORDER BY RAND() LIMIT 1';
		$result = $this->ins_db->query($sql);
		$res = $result->fetch_assoc();
		return $res;
	}

	public function db_count($table){
		$sql = "SELECT COUNT(`id`) FROM `".$table."`";
		$result = $this->ins_db->query($sql);
		$res = $result->fetch_assoc();
		return $res['COUNT(`id`)'];
	}

	public function get_all_in_one_bd($table, $where) {
		$sql = "SELECT COUNT(`id`) FROM `".$table."` WHERE ".$where;
		$result = $this->ins_db->query($sql);
		$res = $result->fetch_assoc();
		return $res['COUNT(`id`)'];
	}

	public function cou_delete(){
		$sql = "DELETE FROM `ip`"; 
		$result = $this->ins_db->query($sql);
	}

	public function cou_ins(){
		$ip = $_SERVER['REMOTE_ADDR']; 
		$sql = "INSERT INTO `ip` SET `ip`='{$ip}'"; 
		$result = $this->ins_db->query($sql);
	}

	public function cou_ins_2(){
		$date = date("Y-m-d");
		$sql = "INSERT INTO `count` SET  
              `date`= '{$date}', 
              `host`=1,  
              `hit`=1";
		$result = $this->ins_db->query($sql);
	}

	public function cou_ins_3(){
		$ip = $_SERVER['REMOTE_ADDR']; 
		$sql = "SELECT `id` FROM `ip` WHERE `ip`='{$ip}'"; 
	 	$result = $this->ins_db->query($sql);
		return $result->fetch_assoc();
	}
	
	public function cou_ins_4(){
		$date = date("Y-m-d");
		$sql = "UPDATE `count` SET `hit`=`hit`+1 WHERE `date`='{$date}'";
		$this->ins_db->query($sql);
	}

	public function cou_ins_5(){
		$ip = $_SERVER['REMOTE_ADDR'];
		$sql = "INSERT INTO `ip` SET `ip`='{$ip}'";
		$this->ins_db->query($sql);
	}

	public function cou_ins_6(){
		$date = date("Y-m-d"); 
		$sql = "UPDATE `count` SET  
              `host`=`host`+1,  
              `hit`=`hit`+1 WHERE `date`='{$date}'";
		$this->ins_db->query($sql);
	}
}
?>