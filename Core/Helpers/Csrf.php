<?php

namespace Core\Helpers;

class Csrf
{
	public $size = 50;
	public $time = 600;
	public $name = 'csrf';
	protected static $instance = null;
	
	private function __construct() {}
	
	public static function instance()
	{
		if (self::$instance === null) self::$instance = new self;
		
		if ($config = config('app.csrf'))
		{
			foreach($config as $key => $value)
			{
				self::$instance->$key = $value;
			}
		}
		return self::$instance;
	}
	
	public function get($type = false)
	{
		$csrf = self::instance();
		$response = false;
		
		if ($csrf->isset())
		{
			if (!$type)
			{
				$response = $_SESSION[$csrf->name];
			}
			elseif ($type == 'input')
			{
				$response = '<input type="hidden" name="'.$csrf->name.'" value="'.$_SESSION[$csrf->name].'">';
			}
			elseif ($type == 'meta')
			{
				$response = '<meta name="'.$csrf->name.'" content="'.$_SESSION[$csrf->name].'">';
			}
		}
		return $response;
	}
	
	public static function update()
	{
		$csrf = self::instance();
		
		if (!$csrf->isset())
		{
			$csrf->set();
		}
		else
		{
			$endTime = $_SESSION[$csrf->name.'_time'];
			
			if ($endTime < time())
			{
				$csrf->set();
			}
		}
	}
	
	public static function set($value = false)
	{
		$csrf = self::instance();
		$hash = !$value ? randString($csrf->size) : $hash;
		
		$_SESSION[$csrf->name] = $hash;
		$_SESSION[$csrf->name.'_time'] = time() + $csrf->time;
	}
	
	public function isset()
	{
		return !empty($_SESSION[self::instance()->name]);
	}
	
	public static function check($string = null)
	{
		$csrf = self::instance();
		$response = false;
		
		if ($csrf->isset())
		{
			if (!$string) 
				$value = request(true)->request->has($csrf->name) ? request(true)->request->get($csrf->name) : false;
			else
				$value = $string;
			
			if (strlen($csrf->get()) == strlen($value))
			{
				if ($csrf->get() === $value) $response = true;
			}
		}
		return $response;
	}
	
	private function __clone() {}
	private function __wakeup() {}
}
