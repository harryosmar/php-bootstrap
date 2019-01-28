<?php
/**
 * Created by PhpStorm.
 * User: harryosmar
 * Date: 1/28/19
 * Time: 11:34 PM
 */

namespace PhpBootstrap\ServiceProviders;


use League\Container\ServiceProvider\AbstractServiceProvider;
use PhpBootstrap\Services\RabbitMQMessagingSystem;

class MessagingSystem extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        \PhpBootstrap\Contracts\MessagingSystem::class
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
        /**
         * by registering the helloworld implementation as an alias of it's interface it
         * is easy to swap out for other implementations
         */
        $this->getContainer()
            ->add(\PhpBootstrap\Contracts\MessagingSystem::class, RabbitMQMessagingSystem::class);
    }
}