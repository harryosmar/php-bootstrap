<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 5:48 PM
 */

namespace PhpBootstrap\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ExampleMiddleware
{
    public function checkToken(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if (!preg_match('/access_token/', $request->getUri()->getQuery())) {
            $response->getBody()->write(json_encode([
                'message' => 'token required'
            ]));

            return $response->withStatus(400);
        }

        return $next($request, $response);
    }
}