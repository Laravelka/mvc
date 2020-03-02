<?php

namespace Core;

use Rakit\Validation\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class Controller
{
	/**
	 * Экземпляр класса Request
	 * 
	 * @var Symfony\Component\HttpFoundation\Request
	 */
	protected $request;

	/**
	 * Экземпляр класса Validator
	 * 
	 * @var Rakit\Validation\Validator
	 */
	protected $validator;
	
	public function __construct()
	{
		$this->request = request();
		$this->validator = new Validator;
	}
}
