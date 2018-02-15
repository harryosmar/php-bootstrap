<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/15/18
 * Time: 12:47 PM
 */

namespace PhpBootstrap\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use PhpBootstrap\Controller\HelloWorld;

/**
 * Class ControllerProviders
 * @package PhpBootstrap
 * Handle all your controller dependency injection here
 */
class Controller extends AbstractServiceProvider
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