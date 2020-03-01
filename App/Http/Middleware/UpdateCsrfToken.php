<?php declare(strict_types=1);

namespace App\Http\Middlewares;

use Core\Helpers\Csrf;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;

class UpdateCsrfToken implements MiddlewareInterface
{
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
	{
		Csrf::update();
		
		return $handler->handle($request);
	}
}
