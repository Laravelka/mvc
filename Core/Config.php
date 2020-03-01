<?php 

namespace Core;

class Config
{
	public $cacheConfigs = [];
	protected static $instance = null;
	
	private function __construct() {}
	
	public static function instance()
	{
		if (self::$instance === null) self::$instance = new self;
		
		return self::$instance;
	}
	
	public function get($string, $default)
	{
		$config = self::instance();
		$match = explode('.', $string);
		
		if (!isset($config->cacheConfigs[$match[0]]))
		{
			$array = require ROOT.'/config/'.$match[0].'.php';
			
			$config->cacheConfigs = array_merge($config->cacheConfigs, [
				$match[0] => $array
			]);
		}
		else
		{
			$array = $config->cacheConfigs[$match[0]];
		}
		unset($match[0]);
		
		foreach($match as $value)
		{
			if (isset($array[$value]))
			{
				$array = $array[$value];
			}
			else
			{
				return $default;
			}
		}
		return $array;
	}
	
	private function __clone() {}
	private function __wakeup() {}
}
