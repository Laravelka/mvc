<?php

namespace App\Http\Controllers;

use Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
	public function login()
	{
		return response()->view('auth.login');
	}
	
	public function register()
	{
		return response()->view('auth.register');
	}
}
