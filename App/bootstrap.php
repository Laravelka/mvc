<?php

/**
 * Bootstrap file
 *
 * PHP Version 7.3
 */
require ROOT.'/vendor/autoload.php';

Base::$debug = 1;
Base::connect('mysql', config('db.mysql')) or die('Нет подключения.');

$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$router = new League\Route\Router;

$router->middlewares([
    new App\Http\Middlewares\UpdateCsrfToken
]);

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler; 

if (config('app.debug'))
{
	ErrorHandler::register();
	ExceptionHandler::register();
}
else
{
	set_error_handler('Core\Error::errorHandler');
	set_exception_handler('Core\Error::exceptionHandler');
}

include ROOT.'/routes/api.php';
include ROOT.'/routes/web.php';

$response = $router->dispatch($request);

(new Zend\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);
