<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 3:46 PM
 */
require __DIR__ . '/../vendor/autoload.php';

$app = new \PhpBootstrap\App(new League\Container\Container);

$app->getContainer()->get('emitter')->emit(
    $app->handle()
);