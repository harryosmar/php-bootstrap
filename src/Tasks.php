<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 4:10 PM
 */

namespace PhpBootstrap;

use PhpBootstrap\Console\HelloWorld;
use Symfony\Component\Console\Application;

class Tasks
{
    final public static function register(Application $application)
    {
        $application->add(new HelloWorld());
    }
}