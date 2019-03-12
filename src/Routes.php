<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 4:21 PM
 */

namespace PhpBootstrap;

use League\Container\Container;
use League\Route\RouteGroup;
use PhpBootstrap\Controller\HelloWorld;
use PhpBootstrap\Middleware\DummyTokenChecker;
use PhpBootstrap\Contracts\Response;
use PhpBootstrap\Middleware\Response\applicationJSON;
use PhpBootstrap\Middleware\Response\textHTML;
use Psr\Http\Message\ServerRequestInterface;
use League\Route\RouteCollection;

class Routes
{
    final public static function collections(
        RouteCollection $route,
        Container $container
    ) {
        /**
         * Content-Type: application/json
         */
        $route->group('', function (RouteGroup $route) use ($container) {
            $route->map(
                'GET',
                '/',
                function (ServerRequestInterface $request, Response $response) {
                    return $response->withArray(['Hello' => 'World']);
                }
            );

            $route->map(
                'GET',
                '/hello/{name}',
                [
                    new HelloWorld(
                        $container->addServiceProvider(new \PhpBootstrap\ServiceProviders\Controller\HelloWorld)
                    ),
                    'sayHi'
                ]
            )->middleware(new DummyTokenChecker());

        })->middleware(new applicationJSON());

        /**
         * Content-Type: text/html
         */
        $route->group('', function (RouteGroup $route) use ($container) {

            $route->map(
                'GET',
                '/html',
                function (ServerRequestInterface $request, Response $response) {
                    $response->getBody()->write('<h1>Home Page!</h1>');
                    return $response->withStatus(200);
                }
            );

            $route->map(
                'GET',
                '/login',
                function (ServerRequestInterface $request, Response $response) {
                    // Create new Plates instance
                    $templates = new \League\Plates\Engine(implode(DIRECTORY_SEPARATOR, [dirname(__FILE__), '..', 'resources', 'templates']));
                    $response->getBody()->write(
                        $templates->render('login')
                    );
                    return $response->withStatus(200);
                }
            );

            $route->map(
                'POST',
                '/login',
                function (ServerRequestInterface $request, Response $response) {
                    $response->getBody()->write(
                        sprintf('Hello, %s', $request->getParsedBody()['Username'])
                    );
                    return $response->withStatus(200);
                }
            );

        })->middleware(new textHTML());
    }
}