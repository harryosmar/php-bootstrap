<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 4:25 PM
 */

namespace PhpBootstrap;

use League\Container\ServiceProvider\AbstractServiceProvider;
use PhpBootstrap\Services\Hello;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response;


class ServiceProviders extends AbstractServiceProvider
{
    protected $provides = [
        'response',
        'request',
        'emitter',
        \PhpBootstrap\Contracts\Hello::class
    ];

    public function register()
    {
        $this->getContainer()->share('response', Response::class);

        $this->getContainer()->share(
            'request',
            function () {
                return ServerRequestFactory::fromGlobals(
                    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
                );
            }
        );

        $this->getContainer()->share('emitter', \Zend\Diactoros\Response\SapiEmitter::class);

        // by registering the helloworld implementation as an alias of it's interface it
        // is easy to swap out for other implementations
        $this->getContainer()
            ->add(\PhpBootstrap\Contracts\Hello::class, Hello::class);
    }
}