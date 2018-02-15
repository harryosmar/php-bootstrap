<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/15/18
 * Time: 12:48 PM
 */

namespace PhpBootstrap\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use PhpBootstrap\Services\Hello;
use PhpBootstrap\Contracts\Response as ResponseInterface;
use Zend\Diactoros\ServerRequestFactory;
use PhpBootstrap\Services\Response;

/**
 * Class ServiceProviders
 * @package PhpBootstrap
 * All your library/services need to be registered in the container
 */
class Library extends AbstractServiceProvider
{
    protected $provides = [
        ResponseInterface::class,
        'request',
        'emitter',
        \PhpBootstrap\Contracts\Hello::class
    ];

    public function register()
    {
        $this->getContainer()->share(ResponseInterface::class, Response::class);

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