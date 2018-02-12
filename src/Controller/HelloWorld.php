<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 5:20 PM
 */

namespace PhpBootstrap\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HelloWorld
{
    public function sayHi(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /**
         * http://route.thephpleague.com/json-strategy/
         */
        $response->getBody()->write(json_encode([
            'message' => 'Hi ' . $args['name']
        ]));
        return $response->withStatus(200);
    }
}