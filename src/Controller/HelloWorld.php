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

class HelloWorld extends Base
{
    public function sayHi(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        /** @var HelloInterface $hello */
        $hello = $this->container->get(HelloInterface::class);

        return $response->withArray(
            [
                'message' => sprintf('%s %s', $hello->sayHi(), $args['name'])
            ],
            200
        );
    }
}