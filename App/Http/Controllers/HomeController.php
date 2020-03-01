<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Core\Controller;
use App\Models\News;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController extends Controller
{
	public function welcome(ServerRequestInterface $request, $args) : ResponseInterface
	{
		$news = new News;
		
		$data = [
			'news' => $news->last()
		];
		return response($data)->view('welcome');
	}
}
