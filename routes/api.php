<?php

$router->group('/api', function($router) {
    $router->get('/logs', 'App\Http\Controllers\Api\CheckLogsController::wate');
	$router->post('/login', 'App\Http\Controllers\Api\AuthController::login');
	$router->post('/register', 'App\Http\Controllers\Api\AuthController::register');
});
