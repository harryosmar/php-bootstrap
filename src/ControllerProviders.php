<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/13/18
 * Time: 11:53 AM
 */

namespace PhpBootstrap;


use League\Container\ServiceProvider\AbstractServiceProvider;
use PhpBootstrap\Controller\HelloWorld;
use PhpBootstrap\Services\HelloInterface;

class ControllerProviders extends AbstractServiceProvider
{

    protected $provides = [
        'helloworldcontroller'
    ];

    public function register()
    {
        $this->getContainer()->add('helloworldcontroller', HelloWorld::class)->withArguments([
            HelloInterface::class
        ]);
    }
}