<?php
/**
 * Created by PhpStorm.
 * User: harryosmar
 * Date: 2/3/19
 * Time: 8:58 PM
 */

namespace Tests\unit;


use PhpBootstrap\Services\LcobucciJWTGenerator;

class TokenTest extends Base
{
    /**
     * @test
     */
    public function shouldBeAbleToGenerateToken() {
        $tokenGenerator = new LcobucciJWTGenerator();
        $tokenPayload = $tokenGenerator->generateToken(1, 'http://example.org', ['key' => 'value']);
        $this->assertTrue($tokenGenerator->validateData(1, 'http://example.org', $tokenPayload));
        $this->assertTrue($tokenGenerator->verifySignature($tokenPayload, 1));
    }
}