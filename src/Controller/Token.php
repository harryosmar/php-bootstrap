<?php
/**
 * Created by PhpStorm.
 * User: harryosmar
 * Date: 2/3/19
 * Time: 7:51 PM
 */

namespace PhpBootstrap\Controller;

use PhpBootstrap\Contracts\TokenGenerator;
use PhpBootstrap\Contracts\Response as ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Token extends Base
{
    public function store(ServerRequestInterface $request, ResponseInterface $response) {
        /** @var TokenGenerator $tokenGenerator */
        $tokenGenerator = $this->container->get(\PhpBootstrap\Contracts\TokenGenerator::class);
        $params = $request->getParsedBody();
        $token = $tokenGenerator->generateToken($params['client_id'], $params['audience'], $params['data']);
        return $response->withArray([
            'token' => $token
        ]);
    }
}