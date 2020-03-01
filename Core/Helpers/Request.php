<?php

namespace Core\Helpers;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Request
{
	public $__symfony;
	protected static $__instance = null;
	
	private function __construct() {}
	
	public static function instance()
	{
		if (self::$__instance === null)
		{
			self::$__instance = new self;
		}
		self::$__instance->__symfony = SymfonyRequest::createFromGlobals();
		
		if (!empty(self::$__instance->all()))
		{
			foreach(self::$__instance->all() as $key => $value)
			{
				self::$__instance->$key = $value;
			}
		}
		return self::$__instance;
	}
	
	public static function input($key, $default = false)
	{
		$class = self::instance();
		$response = null;
		
		if (isset($class->{$key}))
		{
			$response = $class->{$key};
		}
		elseif ($default !== false)
		{
			$response = $default;
		}
		return $response;
	}
	
	public static function has($key)
	{
		$class = self::instance();
		$response = false;
		
		if (isset($class->{$key}))
		{
			$response = true;
		}
		return $response;
	}
	
	public static function all($isObject = false)
	{
		$response = array_merge(self::$__instance->__symfony->request->all(), self::$__instance->__symfony->query->all());
		
		return !$isObject ? (object) $response : $response;
	}
}
