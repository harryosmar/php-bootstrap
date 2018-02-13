<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 5:20 PM
 */

namespace PhpBootstrap\Controller;

use PhpBootstrap\Contracts\Hello as HelloInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HelloWorld
{
    /**
     * @var HelloInterface
     */
    private $hello;

    public function __construct(HelloInterface $hello)
    {
        $this->hello = $hello;
    }

    public function sayHi(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /**
         * http://route.thephpleague.com/json-strategy/
         */
        $response->getBody()->write(json_encode([
            'message' => sprintf('%s %s', $this->hello->sayHi(), $args['name'])
        ]));
        return $response->withStatus(200);
    }
}