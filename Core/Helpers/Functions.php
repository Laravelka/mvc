<?php

use Core\{Config, View};
use Core\Helpers\{Response, Request, Csrf};
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

if (!function_exists('request'))
{
	function request($returnSymfony = false)
	{
		$response = Request::instance(); // Request::createFromGlobals();
		
		return ($returnSymfony ? $response->__symfony : $response);
	}
}

if (!function_exists('response'))
{
	function response($data = [])
	{
		return Response::instance($data);
	}
}

if (!function_exists('redirect'))
{
	function redirect($url, $permanent = false)
	{
		if ($permanent)
		{
			header('Location:'.$url, true, 301);
		}
        else
        {
            header('Location:'.$url);
        }
	}
}

if (!function_exists('config'))
{
	function config($string, $default = false)
	{
		$config = Config::instance();
		
		return $config->get($string, $default);
	}
}

if (!function_exists('csrf'))
{
	function csrf()
	{
		return Csrf::instance();
	}
}

if (!function_exists('view'))
{
	function view($file, $data = [])
	{
		$view = new View;
        return $view->render($file, $data);
	}
}

if (!function_exists('randString'))
{
	function randString($size = 10)
	{
		return substr(base64_encode(random_bytes($size)), 0, $size);
	}
}

if (!function_exists('base64Decode'))
{
    function base64Decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
    }
}

if (!function_exists('base64Encode'))
{
    function base64Encode($data)
    { 
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
    }
}