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

class DummyTokenChecker
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if (!preg_match('/access_token/', $request->getUri()->getQuery())) {
            return $response->errorUnauthorized();
        }

        return $next($request, $response);
    }
}