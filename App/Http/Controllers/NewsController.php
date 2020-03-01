<?php

namespace App\Http\Controllers;

use Core\Controller;
use App\Models\News;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NewsController extends Controller
{
	public function all(ServerRequestInterface $request, $args) : ResponseInterface
	{
		$news = new News;
		
		$data = $news->getAll([
			'n.*', 'u.login'
		]);
		
		$response = [
			'arrNews' => $data
		];
		return response($response)->view('news.all');
	}
	
	public function getById(ServerRequestInterface $request, $args) : ResponseInterface
	{
		$news = new News;
		
		$data = $news->getById($args['id']);
		
		$response = [
			'news' => $data
		];
		return response($response)->view('news.show');
	}
}
