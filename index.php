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
$serviceProviders->register($container);

$container->share('emitter', \Zend\Diactoros\Response\SapiEmitter::class);

$route = new League\Route\RouteCollection($container);

\PhpBootstrap\Routes::collections($route);

$response = $route->dispatch(
    $container->get('request'),
    $container->get('response')
);

$container->get('emitter')->emit($response);