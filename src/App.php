<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 3/15/18
 * Time: 10:03 AM
 */

namespace PhpBootstrap;

use League\Container\Container;
use League\Route\RouteCollection;

class App
{
    /**
     * @var Container
     */
    private $container;
    /**
     * @var RouteCollection
     */
    private $route;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->registerContainer();
        $this->registerRoute();
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    final public function handle()
    {
        try {
            /**
             * process the request
             */
            return $this->route->dispatch(
                $this->container->get('request'),
                $this->container->get(\PhpBootstrap\Contracts\Response::class)
            );
        } catch (\League\Route\Http\Exception\NotFoundException $exception) {
            /**
             * handle 404
             */
            $response = new \PhpBootstrap\Services\Response();
            return $response->errorNotFound();
        }
    }

    private function registerContainer()
    {
        /**
         * Register all service providers to $container
         */
        \PhpBootstrap\ServiceProviders::register($this->container);
    }

    private function registerRoute()
    {
        /**
         * instantiate $route object
         */
        $this->route = new RouteCollection($this->container);

        /**
         * Register all routes mapping to $route object
         */
        \PhpBootstrap\Routes::collections($this->route, $this->container);
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }
}