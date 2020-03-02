<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Core\Controller;
use App\Models\News;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController extends Controller
{
	/**
	 * @param  Request
	 * @param  array
	 * @return Response
	 */
	public function welcome(Request $request, $args) : Response
	{
		$data = [
			'news' => (new News)->last()
		];
		return response($data)->view('welcome');
	}
}
