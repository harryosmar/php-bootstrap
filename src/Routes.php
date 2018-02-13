<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 4:21 PM
 */

namespace PhpBootstrap;


use League\Container\Container;
use League\Route\Strategy\JsonStrategy;
use PhpBootstrap\Middleware\ExampleMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use League\Route\RouteCollection;

class Routes
{
    /**
     * @param RouteCollection $route
     * http://route.thephpleague.com/
     * @param Container $container
     */
    final public static function collections(
        RouteCollection $route,
        Container $container
    ) {
        /**
         * Using simple object closure
         */
        $route->map(
            'GET',
            '/',
            function (ServerRequestInterface $request, ResponseInterface $response) {
                $response->getBody()->write('<h1>Home Page!</h1>');
                return $response->withStatus(200);
            }
        );

        /**
         * Using controller with passing arguments, check the middleware, then return response as json
         * http://route.thephpleague.com/middleware/
         * http://route.thephpleague.com/json-strategy/
         */
        $route->map(
        'GET',
        '/hello/{name}',
            [
                $container->get('helloworldcontroller'),
                'sayHi'
            ]
        )->setStrategy(new JsonStrategy())
        ->middleware([
            new ExampleMiddleware(), 'checkToken'
        ]);
    }
}