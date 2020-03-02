<?php

namespace App\Http\Controllers;

use Core\Controller;
use App\Models\News;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NewsController extends Controller
{
	/**
	 * Получение всех новостей
	 *
	 * @param  Psr\Http\Message\ServerRequestInterface $request
	 * @param  array $args
	 * @return Psr\Http\Message\ServerRequestInterface
	*/
	public function all(ServerRequestInterface $request, $args) : ResponseInterface
	{
		$data = (new News)->getAll([
			'n.*', 'u.login'
		]);
		
		$response = [
			'arrNews' => $data
		];
		return response($response)->view('news.all');
	}
	
	/**
	 * Получение новости по ее id
	 *
	 * @param  Psr\Http\Message\ServerRequestInterface $request
	 * @param  array $args
	 * @return Psr\Http\Message\ServerRequestInterface
	*/
	public function getById(ServerRequestInterface $request, $args) : ResponseInterface
	{
		$data = (new News)->getById($args['id']);
		
		$response = [
			'news' => $data
		];
		return response($response)->view('news.show');
	}
}
