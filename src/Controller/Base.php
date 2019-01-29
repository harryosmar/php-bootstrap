<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/25/18
 * Time: 9:46 AM
 */

namespace PhpBootstrap\Controller;

use League\Container\Container;

/**
 * Class Base
 * @package PhpBootstrap\Controller
 * This is the base controller
 */
class Base
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * Base constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}