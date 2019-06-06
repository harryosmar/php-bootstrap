<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 4:10 PM
 */

namespace PhpBootstrap;

use League\Container\Container;
use PhpBootstrap\Console\Consumer;
use PhpBootstrap\Console\HelloWorld;
use PhpBootstrap\Console\Producer;
use PhpBootstrap\Console\ProducerSync;
use Symfony\Component\Console\Application;

class Tasks
{
    /**
     * @param Application $application
     * https://symfony.com/doc/current/console.html
     */
    final public static function register(Application $application, Container $container)
    {
        $application->add(new HelloWorld());
        $application->add(new Consumer());
        $application->add(new Producer());
    }
}