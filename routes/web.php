<?php

$router->group('/admin', function ($router) {
	$router->get('/', 'App\Http\Controllers\Admin\HomeController::index');
	$router->get('/files', 'App\Http\Controllers\Admin\HomeController::files');
});

$router->group('/news', function ($router) {
	$router
		->get('/', 'App\Http\Controllers\NewsController::all')
		->setName('news.all');
		
	$router->get('/id{id:number}', 'App\Http\Controllers\NewsController::getById');
});

$router->group('/user', function ($router) {
	$router
		->get('/id{id:number}', 'App\Http\Controllers\UserController::getById')
		->setName('profile');
});

$router
	->get('/', 'App\Http\Controllers\HomeController::welcome')
	->setName('welcome');

$router->get('/logs', function() {
    return response()->view('polling');
});

$router->get('/login', 'App\Http\Controllers\AuthController::login');
$router->get('/register', 'App\Http\Controllers\AuthController::register');
