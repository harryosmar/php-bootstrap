<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 3:46 PM
 */

require __DIR__ . '/vendor/autoload.php';

$container = new League\Container\Container;

$serviceProviders = new \PhpBootstrap\ServiceProviders();
$controllerProviders = new \PhpBootstrap\ControllerProviders();
$container->addServiceProvider($serviceProviders);
$container->addServiceProvider($controllerProviders);

$container->share('emitter', \Zend\Diactoros\Response\SapiEmitter::class);

$route = new League\Route\RouteCollection($container);

\PhpBootstrap\Routes::collections($route, $container);

try {
    $response = $route->dispatch(
        $container->get('request'),
        $container->get('response')
    );
} catch (\League\Route\Http\Exception\NotFoundException $exception) {
    $response = new \Zend\Diactoros\Response();
    $response->getBody()->write('page not found');
    $response->withHeader('Content-Type', 'application/json');
    $response->withStatus(404);
}

$container->get('emitter')->emit($response);