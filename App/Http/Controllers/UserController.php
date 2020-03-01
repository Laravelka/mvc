<?php

namespace App\Http\Controllers;

use Core\Controller;
use App\Models\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserController extends Controller
{
	public function all(ServerRequestInterface $request, $args) : ResponseInterface
	{
		$users = new User;
		
		$data = $users->getAll();
		
		$response = [
			'arrUsers' => $data
		];
		return response($response)->view('user.all');
	}
	
	public function getById(ServerRequestInterface $request, $args) : ResponseInterface
	{
		$users = new User;
		
		$data = $users->getById($args['id']);
		
		$response = [
			'user' => $data
		];
		return response($response)->view('user.show');
	}
}
