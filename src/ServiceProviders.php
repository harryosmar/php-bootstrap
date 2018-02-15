<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 4:25 PM
 */

namespace PhpBootstrap;

use League\Container\Container;

class ServiceProviders
{
    /**
     * Register all service provider here
     * @param Container $container
     */
    public static function register(Container $container)
    {
        $container->addServiceProvider(new \PhpBootstrap\Providers\Library());
        $container->addServiceProvider(new \PhpBootstrap\Providers\Controller());
    }
}