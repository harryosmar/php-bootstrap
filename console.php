#!/usr/bin/env php
<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 3:47 PM
 */
require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();

$container = new League\Container\Container;

/**
 * Register all service providers to $container
 */
$container->addServiceProvider(new \PhpBootstrap\CoreServiceProvider);

\PhpBootstrap\Tasks::register($application, $container);

$application->run();