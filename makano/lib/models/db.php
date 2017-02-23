<?php class db extends makano {
	static $queries, $tables, $pdo;
	function __construct($arg=array()){ 
		// debug($arg);
		if(!empty(self::$pdo) && empty($arg)) return; 
		self::$queries = self::$tables = array();
		$h = (@$arg['host']?$arg['host']:@DBHOST); $n = (@$arg['name']?$arg['name']:@DBNAME);
		$u = (@$arg['user']?$arg['user']:@DBUSER); $p = (@$arg['pass']?$arg['pass']:@DBPASS);
		$t = (@$arg['type']?$arg['type']:'mysql'); $port = (@$arg['port']?$arg['port']:3306); 

		try { 
			switch ($t) {
				case 'mysql': $dsn = 'mysql:host='.$h.';port='.$port.';dbname='.$n.';charset=utf8'; break;
				case 'mssql': $dsn = 'dblib:host='.$h.':'.$port.';dbname='.$n.';charset=utf8'; break;
				// case 'mssql': $dsn = 'sqlsrv:server='.$h.',port='.$port.';database='.$n; break;
				// case 'mssql': $dsn = 'sqlsrv:server='.$h.',port='.$port.';dbname='.$n; break;
				// case 'mssql': $dsn = 'mssql:host='.$h.';dbname='.$n; break;
			}
			// debug(array($arg, $dsn));
			self::$pdo = new PDO($dsn, $u, $p);
		} catch (PDOException $e) { debug($e->getMessage()); return; }
		if($t=='mysql') {
			$res = self::$pdo->query('SET NAMES UTF8'); 
			$query = 'SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH FROM `information_schema`.`columns` WHERE `table_schema` = "'.$n.'"';
			$res = self::$pdo->query($query)->fetchAll(PDO::FETCH_ASSOC); 
			array_push(self::$queries, array('path'=>preg_replace('~'.preg_quote(DIR_SITE).'~', '', __FILE__).' ('.__LINE__.')', 'query'=>$query));
			foreach ($res as $i) @self::$tables[$i['TABLE_NAME']][$i['COLUMN_NAME']] = $i;
		}
	}
	function get($name='tmp'){ if(isset(self::$$name)) return self::$$name; else return ''; }
	function sql($arg=''){ 
		// if(!self::$pdo) return $this;
		$res = self::$pdo->query($arg); 
		$a = debug_backtrace(); array_push(self::$queries, array(
			'path'=>
				preg_replace('~'.preg_quote(DIR_SITE).'~', '', $a[0]['file']).' ('.$a[0]['line'].')'
				.preg_replace('~'.preg_quote(DIR_SITE).'(.*)$~', ' < $1 ('.@$a[1]['line'].')', @$a[1]['file'])
				.preg_replace('~'.preg_quote(DIR_SITE).'(.*)$~', ' < $1 ('.@$a[2]['line'].')', @$a[2]['file'])
				.preg_replace('~'.preg_quote(DIR_SITE).'(.*)$~', ' < $1 ('.@$a[3]['line'].')', @$a[3]['file'])
				.preg_replace('~'.preg_quote(DIR_SITE).'(.*)$~', ' < $1 ('.@$a[4]['line'].')', @$a[4]['file'])
			, 'query'=>$arg
		));
		if(!is_object($res)) { $res = self::$pdo->errorInfo(); debug($a[0]['file'].' ('.$a[0]['line'].') '.PHP_EOL.$res[2].PHP_EOL.'query: '.$arg); return $this; }
		if(preg_match('~^insert~i', $arg)){ $this->lastid = self::$pdo->lastInsertId(); $this->max = $res->rowCount(); } else
		if(preg_match('~^update~i', $arg)){ $this->max = $res->rowCount(); } else
		if(preg_match('~^delete~i', $arg)){ $this->max = $res->rowCount(); } else
		if(preg_match('~^select~i', $arg)){ $this->items = $res->fetchAll(PDO::FETCH_ASSOC); 
			$this->max = count($this->items);
			if($this->max && preg_match('~^select sql_calc_found_rows~i', $arg)) { $this->max = self::$pdo->query($query = 'SELECT found_rows()')->fetchColumn(0); array_push(self::$queries, array('place'=>$a[0]['file'].' ('.$a[0]['line'].')', 'query'=>$query)); } else
			if($this->max && preg_match('~^.+from (.+)limit \d+(,\d+)?$~is', $arg, $m)) { 
				$this->max = self::$pdo->query($query = 'SELECT count(*) FROM '.$m[1]); 
				$this->max = $this->max->fetchAll(PDO::FETCH_COLUMN); 
				$this->max = array_sum($this->max);
				array_push(self::$queries, array('path'=>preg_replace('~'.preg_quote(DIR_SITE).'~', '', $a[0]['file']).' ('.$a[0]['line'].')', 'query'=>$query)); 
			} else if($this->max) $this->max = count($res);
			$this->ids = array(); foreach ($this->items as &$i) array_push($this->ids, @$i['_id']); unset($i);
		} $this->query = $arg; 
		return $this;
	}
	function insert($table, $arg=array()){ 
		$t = self::$tables; $cols = $vals = $val = '';
		if(!empty($arg)) {
			if(is_array(@$arg[0])) foreach ($arg as $k => &$v) { 
				$val = ''; foreach ($v as $i => &$j) if(isset($t[$table][$i])) { 
					if(!$k) $cols.= ($cols?',':'').'`'.$i.'`';
					$val .= ($val?',':'').'"'.preg_replace('~"~', '\"', $j).'"';
				} 
				$vals.=($vals?',':'').'('.$val.')';
			} else {
				foreach ($arg as $k => &$v) if(isset($t[$table][$k])) { 
					$cols.= ($cols?',':'').'`'.$k.'`';
					$vals.= ($vals?',':'').'"'.preg_replace('~"~', '\"', $v).'"';
				} $vals='('.$vals.')';
			}
			unset($v);
		} 
		// debug(array($cols,$vals,$arg));
		if($cols&&$vals) {
			$query = 'INSERT IGNORE INTO '.$table.' ('.$cols.') VALUES '.$vals;
			return $this->sql($query);
		} else return $this;
	}
	function remove($table, $arg=array()){ 
		$t = self::$tables; $where = $arg; foreach ($where as $k => &$v) 
			if(isset($t[$table][$k]))
				$v = 'AND `'.$k.'` IN ('.preg_replace(array('~"~', '~([^,\d]+)~', '~^$~'), array('\"', '"$1"', '""'), $v).')'; 
			else unset($where[$k]); 
		unset($v); if(!empty($where)) {
			$query = 'DELETE FROM '.$table.' WHERE 1 '.implode("", $where);
			return $this->sql($query);
		} else return $this;
	}
	function update($arg=array()){ 
		$t = self::$tables; $tables = array();
		($data  = @$arg['data']) 	|| ($data = array());			
		($joins = @$arg['joins'])	|| ($joins = array(key($t)));
		($where = @$arg['where'])	|| ($where = array());			
		foreach ($joins as $k => &$v) { array_push($tables, (is_string($k)?$k:preg_replace('~ .*$~', '', $v))); if(is_string($k)) $v = 'LEFT JOIN `'.$k.'` USING (`'.$v.'`)'; else $v = preg_replace('~^(.+?)( .*)$~', '`$1`$2', $v); } unset($v);
		foreach ($data as $k => &$v) { $found = 0;
			foreach ($tables as $t1) if(isset($t[$t1][$k])) { $found = 1;
				$v = '`'.$k.'` = "'.preg_replace('~"~', '\"', htmlspecialchars_decode($v)).'"';
				break;
			} if(!$found) unset($data[$k]); 
		} unset($v);
		foreach ($where as $k => &$v) if($v) { $found = 0;
			foreach ($tables as $t1) if(isset($t[$t1][$k])) { $found = 1;
				$v = 'AND `'.$k.'` IN ('.preg_replace(array('~"~', '~([^,]+)~', '~^$~'), array('\"', '"$1"', '""'), $v).')'; 
				break;
			} if(!$found) unset($where[$k]); 
		} unset($v);
		if(!empty($data)&&$where){
			$query = 'UPDATE '.implode("\r\n\t", $joins).' SET '.implode("\r\n\t, ", $data)."\r\n".'WHERE 1 '.implode("\r\n\t", $where);
			return $this->sql($query);
		} else return $this;
	}
	function find($arg=array()){
		$t = self::$tables; $tables = array();
		($cols  = @$arg['cols']) 	|| ($cols = array('*'));		($joins = @$arg['joins'])	|| ($joins = array(key($t)));
		($where = @$arg['where'])	|| ($where = array());			($having = @$arg['having'])	|| ($having = array());
		($group = @$arg['group'])	|| ($group = array());
		($order = @$arg['where']['order'])	|| ($order = '');
		if(isset($arg['where']['start'])) $start = $arg['where']['start']; else $start = $this->start; $this->start = $start;
		if(isset($arg['where']['limit'])) $limit = $arg['where']['limit']; else $limit = $this->limit; $this->limit = $limit;
		foreach ($cols as $k => &$v)  if(is_string($k)) $v = '('.$v.') as '.$k; else if($v!='*') $v = '`'.$v.'`'; unset($v);
		foreach ($joins as $k => &$v) { 
			if(!isset($t[$tbl = preg_replace('~ .*$~', '', is_string($k)?$k:$v)])) { unset($joins[$k]); continue; }
			array_push($tables, $tbl); 
			$v = (is_string($k)?'LEFT JOIN `'.$k.'` USING (`'.$v.'`)':preg_replace('~^(.+?)( .*)$~', '`$1`$2', $v)); 
		} unset($v);
		foreach ($where as $k => &$v) { $found = 0;
			if(preg_match('~^or$~i', $k) && is_array($v)) {
				$j = array(0); foreach ($v as $key => $val) {
					foreach ($tables as $t1) if(isset($t[$t1][$key])) { $found = 1;
						if(preg_match('~^\~(.*)$~', $val, $m))
							$j[] = 'OR `'.$key.'` LIKE "%'.preg_replace(array('~"~', '~[-/\s]~'), array('\"', '%'), $m[1]).'%"'; 
						else if(preg_match('~^<?(.*?)>(.*)$~', $val, $m))
							$j[] = 'OR `'.$key.'` BETWEEN "'.preg_replace('~"~', '\"', $m[1]).'" AND "'.preg_replace('~"~', '\"', $m[2]).'"'; 
						else if(preg_match('~^(<=|>=|<>|!=|=|<|>)(.*)$~', $val, $m))
							$j[] = 'OR `'.$key.'` '.($m[1]=='!='?'<>':$m[1]).' "'.preg_replace('~"~', '\"', $m[2]).'"'; 
						else if(preg_match('~^!(.+)$~', $val, $m))
							$j[] = 'OR `'.$key.'` NOT IN ('.preg_replace(array('~"~', '~([^,]+)~', '~^$~'), array('\"', '"$1"', '""'), $m[1]).')'; 
						else if(preg_match('~^!$~', $val, $m))
							$j[] = 'OR `'.$key.'` IS NOT NULL'; 
						else if(preg_match('~^null$~i', $val, $m))
							$j[] = 'OR `'.$key.'` IS NULL'; 
						else 
							$j[] = 'OR `'.$key.'` IN ('.preg_replace(array('~"~', '~([^,]+)~', '~^$~'), array('\"', '"$1"', '""'), $val).')'; 
						break;
					} if(!$found) unset($v[$key]); 
				}
				$v = 'AND ('.implode(" ", $j).')';
			} else foreach ($tables as $t1) if(isset($t[$t1][$k])) { $found = 1;
				if($k=='group_fullname') debug($v);
				if(preg_match('~\~(.*)$~', $v, $m))
					$v = 'AND `'.$k.'` LIKE "%'.preg_replace(array('~"~', '~[-/\s]~'), array('\"', '%'), $m[1]).'%"'; 
				else if(preg_match('~^<?([\d\.\s-:]+?)>([\d\.\s-:]+?)$~', $v, $m))
					$v = 'AND `'.$k.'` BETWEEN "'.preg_replace('~"~', '\"', $m[1]).'" AND "'.preg_replace('~"~', '\"', $m[2]).'"'; 
				else if(preg_match('~^(<=|>=|<>|!=|=|<|>)(.*)$~', $v, $m))
					$v = 'AND `'.$k.'` '.($m[1]=='!='?'<>':$m[1]).' "'.preg_replace('~"~', '\"', $m[2]).'"'; 
				else if(preg_match('~^!(.+)$~', $v, $m))
					$v = 'AND `'.$k.'` NOT IN ('.preg_replace(array('~"~', '~([^,]+)~', '~^$~'), array('\"', '"$1"', '""'), $m[1]).')'; 
				else if(preg_match('~^!$~', $v, $m))
					$v = 'AND `'.$k.'` IS NOT NULL'; 
				else if(preg_match('~^null$~i', $v, $m))
					$v = 'AND `'.$k.'` IS NULL'; 
				else 
					$v = 'AND `'.$k.'` IN ('.preg_replace(array('~"~', '~([^,]+)~', '~^$~'), array('\"', '"$1"', '""'), $v).')'; 
				break;
			} if(!$found) unset($where[$k]); 
		} unset($v);
		$query = 'SELECT ';
		if(!count($tables)>1) $query .= 'sql_calc_found_rows ';
		$query .= implode("\r\n\t, ", $cols);
		$query .= "\r\n".'FROM '.implode("\r\n\t", $joins);
		if(!empty($where)) $query .= "\r\n".'WHERE 1 '.implode("\r\n\t", $where);
		if(!empty($group)) $query .= "\r\n".'GROUP BY '.implode(', ', $group).' HAVING 1 '.implode("\r\n\t ", $having);
		if(!empty($order)) $query .= "\r\n".'ORDER BY '.$order;
		if($start||$limit) $query .= "\r\n".'LIMIT '.$start.','.$limit;
	
		
		return $this->sql($query);
	}
	function change($arg=array()) {  }
} ?>