<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 5:20 PM
 */

namespace PhpBootstrap\Controller;

use PhpBootstrap\Contracts\Hello as HelloInterface;
use PhpBootstrap\Contracts\Response as ResponseInterface;
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
        return $response->withArray(
            [
                'message' => sprintf('%s %s', $this->hello->sayHi(), $args['name'])
            ],
            200
        );
    }
}