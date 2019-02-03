<?php
/**
 * Created by PhpStorm.
 * User: harryosmar
 * Date: 2/3/19
 * Time: 7:54 PM
 */

namespace PhpBootstrap\Contracts;


interface TokenGenerator
{
    /**
     * @param string $clientId
     * @param string $audience
     * @param array $claims
     * @return string
     */
    public function generateToken(string $clientId, string $audience, array $claims) : string;

    /**
     * @param string $clientId
     * @param string $audience
     * @param string $payload
     * @return bool
     */
    public function validateData(string $clientId, string $audience, string $payload) : bool;

    /**
     * @param string $payload
     * @param string $clientId
     * @return bool
     */
    public function verifySignature(string $payload, string $clientId) : bool;
}