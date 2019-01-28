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
use Symfony\Component\Dotenv\Dotenv;

$application = new Application();

$container = new League\Container\Container;

$dotenv = new Dotenv();
$dotenv->load(implode(DIRECTORY_SEPARATOR, [dirname(__FILE__), '.env']));

/**
 * Register all service providers to $container
 */
$container->addServiceProvider(new \PhpBootstrap\CoreServiceProvider);

\PhpBootstrap\Tasks::register($application, $container);

$application->run();