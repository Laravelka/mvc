<?php

$router->group('/api', function($router) {
	$router->post('/login', 'App\Http\Controllers\Api\AuthController::login');
	$router->post('/register', 'App\Http\Controllers\Api\AuthController::register');
});
