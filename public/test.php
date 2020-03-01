<?php

/*
class RulesException extends Exception {}

class BaseRules {
	protected $values;
	
	protected $messages = [
		'string' => ':attr должно быть строкой.',
		'numeric' => ':attr должно быть числом.',
		'required' => ':attr не должно быть пустым.',
	];
	
	protected $attributes = [
		'test' => 'Тестовое поле',
		'login' => 'Поле логин',
	];
	
	public function __construct($values)
	{
		$this->values = $values;
	}
	
	private function replaceMessage($attr, $key)
	{
		$response = false;
		
		if (!empty($attr) && !empty($key))
		{
			$attribute = ( !empty($this->attributes[$attr]) ? $this->attributes[$attr] : $attr );
			
			$response = str_ireplace(':attr', $attribute, $this->messages[$key]);
		}
		else
		{
			throw new RulesException('Параметры не могут быть пустыми');
		}
		return $response;
	}
	
	public function hasMessage($key)
	{
		$response = false;
		
		if (array_key_exists($key, $this->messages)) 
		{
			$response = true;
		}
		return $response;
	}
	
	public function string($key)
	{
		return (!empty($this->values[$key]) && !is_string($this->values[$key]) ? $this->replaceMessage($key, 'string') : true);
	}
	
	public function required($key)
	{
		return (!array_key_exists($key, $this->values) ? $this->replaceMessage($key, 'required') : true);
	}
	
	public function numeric($key)
	{
		return (!empty($this->values[$key]) && !is_numeric($this->values[$key]) ? $this->replaceMessage($key, 'numeric') : true);
	}
}

class ValidateException extends Exception {}

class Validate
{
	protected $errors = false;
	
	public function __construct($values, $params)
	{
		foreach($params as $key => $rules)
		{
			$arrRules = ( !is_array($rules) ? explode('|', $rules) : $rules );
			
			foreach($arrRules as $rule)
			{
				$classRule = new BaseRules($values);
				
				if ($classRule->hasMessage($rule))
				{
					$message = $classRule->$rule($key, $values);
					
					if ($message !== true) $this->errors[$key] = $message;
				}
				else
				{
					throw new ValidateException('Сообщение с ключем '.$rule.' - не найдено.');
				}
			}
		}
	}
	
	public function fails()
	{
		return !empty($this->errors) ? true : false;
	}
	
	public function errors($key = false)
	{
		if ($key)
		{
			foreach($this->errors as $error)
			{
				if (array_key_exists($key, $error))
				{
					return $error;
				}
			}
		}
		else
		{
			return $this->errors;
		}
	}
}

class Request
{
	protected $_all, $_get, $_post;
	
	public function __construct(...$args)
	{
		$this->_get = $_GET;
		$this->_post = $_POST;
		$this->_all = $_REQUEST;
		
		if (empty($args)) $args = $this->_all;
		
		foreach($args as $arg)
		{
			foreach($arg as $key => $value)
			{
				$this->$key = $value ?? false;
			}
		}
	}
	
	public function all($key = false)
	{
		$response = false;
		
		if ($key && array_key_exists($key, $this->_all)) 
		{
			$response = $this->_all[$key];
		}
		else if (!$key)
		{
			$response = $this->_all;
		}
		return $response;
	}
	
	public function get($key = false)
	{
		$response = false;
		
		if ($key && array_key_exists($key, $this->_get)) 
		{
			$response = $this->_get[$key];
		}
		else if (!$key)
		{
			$response = $this->_get;
		}
		return $response;
	}
	
	public function post($key = false)
	{
		$response = false;
		
		if ($key && array_key_exists($key, $this->_post)) 
		{
			$response = $this->_post[$key];
		}
		else if (!$key)
		{
			$response = $this->_post;
		}
		return $response;
	}
	
	public function escape()
	{
		$params = get_object_vars($this);
		
		foreach($params as $key => $value)
		{
			$this->$key = htmlspecialchars($value);
		}
		return $this;
	}
	
	public function validate($values, $params = false)
	{
		$response = false;
		
		if (!empty($values) && !$params)
		{
			$response = new Validate($this->all(), $values);
		}
		else if (!empty($values) && !empty($params))
		{
			$response = new Validate($values, $params);
		}
		return $response;
	}
}

class Controller
{
	public function login(Request $request)
	{
		$validation = $request->validate(['test' => 'required|string']); 
		
		/*
		$request->validate(
				$_POST,
				['test' => 'required|string']
		);
		
		
		if ($validation->fails())
		{
			return $validation->errors();
		}
		else
		{
			return 'Все збс';
		}
	}
}

$test = (new Controller)->login(new Request);
*/

$time = microtime(true);

class BuilderException extends Exception {}
class Builder
{
	public $sql;
	public static $offset = 0;
	public static $limit = 10;
	public static $column = 'id';
	
	const DESC = true;
	
	private $useExec = false;
	private $useFrom = false;
	private $useSelect = false;
	private $useWhere = false;
	private $useOrderBy = false;
	private $useOffsetAndLimit = false;
	
	private function bindValue($value)
	{
		return is_numeric($value) ? (int) $value : "'".$value."'";
	}
	
	public function __call($name, $args)
	{
		if (preg_match('/^(or|)where(Not|More|Less|)(.*|)/ui', $name, $params))
		{
			$isOr = !empty($params[1]);
			$type = !empty($params[2]) ? strtolower($params[2]) : false;
			$whereType = ($this->useWhere ? ($isOr ? ' OR' : ' AND') : ' WHERE');
			
			if (count($args) == 3)
			{ 
				$operator = $args[1];
			}
			else
			{
				$operator = (
					$type == 'not' ? '<>' : (
						$type == 'more' ? '<' : (
							$type == 'less' ? '<' : '='
						)
					)
				);
			}
			$column = !empty($params[3]) ? strtolower($params[3]) : false;
			
			if (!$column)
			{
				$column = $args[0];
				$value = count($args) == 3 ? $this->bindValue($args[2]) : $this->bindValue($args[1]);
			}
			else
			{
				$value = $this->bindValue($args[0]);
			}
			$this->sql .= $whereType.' `'.$column.'` '.$operator.' '.$value;
			$this->useWhere = true;
		} 
		return $this;
	}
	
	public function select(...$args)
	{
		if (count($args) == 1 && is_array($args))
		{
			$fields = implode(', ', $args[0]);
			$this->sql = 'SELECT '.$fields;
			$this->useSelect = true;
		}
		elseif (count($args) > 0)
		{
			$fields = implode(', ', $args);
			$this->sql = 'SELECT '.$fields;
			$this->useSelect = true;
		}
		return $this;
	}
	
	public function table($name)
	{
		if (!$this->useSelect) $this->sql = 'SELECT *';
		
		$this->sql .= ' FROM `'.$name.'`';
		$this->useFrom = true;
		
		return $this;
	}
	
	public function orderBy($column, $isDesc = true)
	{
		$this->sql .= ' ORDER BY `'.$column.'` '.($isDesc ? 'DESC' : 'ASC');
		$this->useOrderBy = true;
		
		return $this;
	}
	
	public function limit(int $offset = 0, int $limit = 10)
	{
		$this->sql .= ' LIMIT '.$offset.','.$limit;
		$this->useOffsetAndLimit = true;
		
		return $this;
	}
	
	public function exec()
	{
		if (!$this->useFrom) throw new BuilderException('Не указано имя таблицы');
		
		if (!$this->useOrderBy) $this->sql .= ' ORDER BY `'.self::$column.'` DESC';
		if (!$this->useOffsetAndLimit) $this->sql .= ' LIMIT '.self::$offset.','.self::$limit;
		
		return $this->sql;
	}
}

$build = new Builder;

echo $build->select('id', 'login')
				   ->table('user')
				   ->where('access', '<', 3)
				   ->orderBy('access', Builder::DESC)
				   ->limit(0, 50)
				   ->exec();

echo 'time: '.microtime(true) - $time;
