<?php
/**
 * Created by PhpStorm.
 * User: harryosmar
 * Date: 2/3/19
 * Time: 7:47 PM
 */

namespace PhpBootstrap\ServiceProviders\Controller;

use League\Container\ServiceProvider\AbstractServiceProvider;

class TokenGenerator extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        \PhpBootstrap\Contracts\TokenGenerator::class
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $this->getContainer()
            ->add(\PhpBootstrap\Contracts\TokenGenerator::class, \PhpBootstrap\Services\LcobucciJWTGenerator::class);
    }
}