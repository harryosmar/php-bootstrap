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

/**
 * Class ControllerProviders
 * @package PhpBootstrap
 * Handle all your controller dependency injection here
 */
class ControllerProviders extends AbstractServiceProvider
{
    protected $provides = [
        'helloworldcontroller'
    ];

    public function register()
    {
        $this->getContainer()
            ->add('helloworldcontroller', HelloWorld::class)
            ->withArguments([
                \PhpBootstrap\Contracts\Hello::class
            ]);
    }
}