<?php
/**
 * @author    Harry Osmar Sitohang <hsitohang@wayfair.com>
 * @copyright 2018 Wayfair LLC - All rights reserved
 */

namespace PhpBootstrap\ServiceProviders\Controller;

use League\Container\ServiceProvider\AbstractServiceProvider;
use PhpBootstrap\Services\Hello;

class HelloWorld extends AbstractServiceProvider {

  protected $provides = [
      \PhpBootstrap\Contracts\Hello::class
  ];

  /**
   * Use the register method to register items with the container via the
   * protected $this->container property or the `getContainer` method
   * from the ContainerAwareTrait.
   *
   * @return void
   */
  public function register() {
    /**
     * by registering the helloworld implementation as an alias of it's interface it
     * is easy to swap out for other implementations
     */
    $this->getContainer()
        ->add(\PhpBootstrap\Contracts\Hello::class, Hello::class);
  }
}