<?php
/**
 * Created by PhpStorm.
 * User: harryosmar
 * Date: 1/28/19
 * Time: 11:18 PM
 */

namespace PhpBootstrap\Contracts;


interface MessagingSystem
{
    public function publish(string $queueName, string $message);

    public function consume(string $queueName, \Closure $closure);
}