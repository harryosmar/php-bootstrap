<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 6:09 PM
 */

namespace PhpBootstrap\Services;


class Hello implements HelloInterface
{
    public function sayHi()
    {
        return 'Hello';
    }
}