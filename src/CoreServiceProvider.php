<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 4:25 PM
 */

namespace PhpBootstrap;

use League\Container\ServiceProvider\AbstractServiceProvider;
use PhpBootstrap\Services\Response;
use Zend\Diactoros\ServerRequestFactory;

class CoreServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        'response',
        'request',
        'emitter',
    ];

    /**
     * @return void
     */
    public function register()
    {
        $this->getContainer()->share('response', Response::class);

        $this->getContainer()->share(
            'request',
            function () {
              return ServerRequestFactory::fromGlobals();
            }
        );

        $this->getContainer()->share('emitter', \Zend\Diactoros\Response\SapiEmitter::class);
    }
}