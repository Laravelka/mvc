<?php 

namespace Core;

class Config
{
	/**
	 * Кешированные конфиги
	 * 
	 * @var array
	 */
	public $cacheConfigs = [];

	/**
	 * Экземпляр объекта
	 * 
	 * @var null|Core/Config
	 */
	protected static $instance = null;
	
	private function __construct() {}
	

	public static function instance()
	{
		if (self::$instance === null) self::$instance = new self;
		
		return self::$instance;
	}

	/**
	 * Получить значение из конфига
	 * 
	 * @param  string $string
	 * @param  mixed $default
	 * @return false|array
	 */
	public function get(string $string, $default)
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
	
	/** 
	 * Запрет клонирвания
	 * 
	 * @return void
	 */
	private function __clone() {}

	/**
	 * Анологично с __clone
	 *
	 * @return void
	 */
	private function __wakeup() {}
}
