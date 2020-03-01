<?php

namespace Core;

use Rakit\Validation\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class Controller
{
	protected $request;
	protected $validator;
	
	public function __construct()
	{
		$class = get_class($this);
		
		
		
		$this->request = request();
		$this->validator = new Validator;
	}
	
	
}
