<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/15/18
 * Time: 12:47 PM
 */

namespace PhpBootstrap\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use PhpBootstrap\Controller\HelloWorld as ControllerHelloWorld;
use PhpBootstrap\Controller\Seo as ControllerSeo;

/**
 * Class ControllerProviders
 * @package PhpBootstrap
 * Handle all your controller dependency injection here
 */
class Controller extends AbstractServiceProvider
{
    protected $provides = [
        'helloworldcontroller',
        'seocontroller'
    ];

    /**
     * register all controller here
     */
    public function register()
    {
        $this->registerController('helloworldcontroller', ControllerHelloWorld::class);
        $this->registerController('seocontroller', ControllerSeo::class);
    }

    /**
     * @param string $alias
     * @param $concrete
     * auto inject DI container to controller constructor
     */
    private function registerController(string $alias, $concrete)
    {
        $this->getContainer()
            ->add($alias, $concrete)
            ->withArguments([
                $this->getContainer()
            ]);
    }
}