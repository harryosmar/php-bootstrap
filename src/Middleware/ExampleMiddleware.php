<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 5:48 PM
 */

namespace PhpBootstrap\Middleware;


use PhpBootstrap\Contracts\Response as ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ExampleMiddleware
{
    public function checkToken(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if (!preg_match('/access_token/', $request->getUri()->getQuery())) {
            return $response->errorForbidden();
        }

        return $next($request, $response);
    }
}