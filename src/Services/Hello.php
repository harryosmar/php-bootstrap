<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 6:09 PM
 */

namespace PhpBootstrap\Services;

use PhpBootstrap\Contracts\Hello as HelloInterface;

class Hello implements HelloInterface
{
    /**
     * @return string
     */
    public function sayHi() : string
    {
        return 'Hello';
    }
}