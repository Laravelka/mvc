<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Core\Controller;
use App\Models\User;
use Core\Helpers\Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthController extends Controller
{
	public function login(ServerRequestInterface $request, $args) : ResponseInterface
	{
		$validation = $this->validator->validate($request->getParsedBody(), [
			'email' => 'required|email',
			'password' => 'required|min:6',
		]);
		
		if ($validation->fails())
		{
			$data = [
				'error' => true,
				'messages' => $validation->errors()->firstOfAll()
			];
		}
		else
		{
			$data = [
				'message' => 'Вы успешно авторизировались'
			];
		}
		return response($data)->json();
	}
	
	public function register(ServerRequestInterface $request, $args) : ResponseInterface
	{
		$inputs = $request->getParsedBody();

		$validation = $this->validator->validate($inputs, [
			'email' => 'required|email',
			'password' => 'required|min:6',
			'first_name' => 'required|min:2',
			'last_name' => 'required|min:2'
		]);
	
		if ($validation->fails())
		{
			$data = [
				'error' => true,
				'messages' => $validation->errors()->firstOfAll()
			];
		}
		else
		{
			$user = new User;
			
			$userId = $user->create($inputs);
			
			$data = [
				'message' => 'Регистрация прошла успешно'
			];
		}
		return response($data)->json();
	}
}
