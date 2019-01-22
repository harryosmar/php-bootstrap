<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/22/19
 * Time: 10:22 PM
 */

namespace PhpBootstrap\Middleware\Response;

use PhpBootstrap\Contracts\Response as ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class applicationJSON
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        return $next($request, $response->asJSON());
    }
}