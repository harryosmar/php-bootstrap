<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 3/15/18
 * Time: 10:03 AM
 */

namespace PhpBootstrap;

use League\Container\Container;
use League\Route\Http\Exception\NotFoundException;
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

    /**
    * @var CoreServiceProvider
    */
    private $serviceProvider;

    /**
     * App constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->registerServices();
        $this->registerRoute();
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    final public function handle()
    {
      $request = $this->container->get('request');
      $response = $this->container->get('response');

      try {
          return $this->route->dispatch(
              $request,
              $response
            );
        } catch (NotFoundException $exception) {
            /**
             * handle 404
             */
            return $response->errorNotFound();
        }
    }

    /**
     * @return Container
     */
    final public function getContainer(): Container
    {
        return $this->container;
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

    private function registerServices()
    {
        $this->serviceProvider = new CoreServiceProvider();
        $this->container->addServiceProvider($this->serviceProvider);
    }
}