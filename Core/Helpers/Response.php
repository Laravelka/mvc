<?php declare(strict_types=1);

namespace Core\Helpers;

use Core\View;
use Zend\Diactoros\Response as ZendResponse;

class Response
{
	public $data = [];
	protected static $instance = null;
	
	private function __construct() {}
	
	public static function instance($data = [])
	{
		if (self::$instance === null) self::$instance = new self;
		
		if (!empty($data) && is_array($data))
		{
			self::$instance->data = array_merge(self::$instance->data, $data);
		}
		self::$instance->view = new View;
		self::$instance->response = new ZendResponse;
		
		return self::$instance;
	}
	
	public function view(String $file, Int $status = 200)
	{
		$class = self::instance();
		$response = $class->response;
		
		$content = $class->view->render($file, $this->data);
		
		$response->getBody()->write($content);
		
		return $response->withStatus($status);
	}
	
	public function json(Int $status = 200)
	{
		$class = self::instance();
		$response = $class->response;
		
		$content = json_encode($class->data, JSON_UNESCAPED_UNICODE);
		
		$response->getBody()->write($content);
		
		return $response->withAddedHeader('content-type', 'application/json')->withStatus($status);
	}
	
	private function __clone() {}
	
	private function __wakeup() {}
}
