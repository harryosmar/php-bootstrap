<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 4:21 PM
 */

namespace PhpBootstrap;


use League\Route\Strategy\JsonStrategy;
use PhpBootstrap\Controller\HelloWorld;
use PhpBootstrap\Middleware\ExampleMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use League\Route\RouteCollection;

class Routes
{
    /**
     * @param RouteCollection $route
     * http://route.thephpleague.com/
     */
    final public static function collections(
        RouteCollection $route
    ) {
        /**
         * Using simple object closure
         */
        $route->map(
            'GET',
            '/',
            function (ServerRequestInterface $request, ResponseInterface $response) {
                $response->getBody()->write('<h1>Home Page!</h1>');
                return $response;
            }
        );

        /**
         * Using controller with passing arguments, check the middleware, then return response as json
         */
        $route->map(
        'GET',
        '/hello/{name}',
            [new HelloWorld(), 'sayHi']
        )->setStrategy(new JsonStrategy())->middleware([
            new ExampleMiddleware(), 'checkToken'
        ]);
    }
}