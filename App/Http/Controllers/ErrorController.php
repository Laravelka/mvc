<?php

namespace App\Http\Controllers;

use Core\Controller;

class ErrorController extends Controller
{
	public function all($request, $args)
	{
		return response()->view('errors.all');
	}
}