<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 3:46 PM
 */

require __DIR__ . '/../vendor/autoload.php';

/**
 * instantiate the dependency injection $container object
 */
$container = new League\Container\Container;

/**
 * Register all service providers to $container
 */
\PhpBootstrap\ServiceProviders::register($container);

/**
 * instantiate $route object
 */
$route = new League\Route\RouteCollection($container);

/**
 * Register all routes mapping to $route object
 */
\PhpBootstrap\Routes::collections($route, $container);

try {
    /**
     * process the request
     */
    $response = $route->dispatch(
        $container->get('request'),
        $container->get(\PhpBootstrap\Contracts\Response::class)
    );
} catch (\League\Route\Http\Exception\NotFoundException $exception) {
    /**
     * handle 404
     */
    $response = new \PhpBootstrap\Services\Response();
    $response = $response->errorNotFound();
}

/**
 * Display the response
 */
$container->get('emitter')->emit($response);