<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/13/18
 * Time: 2:11 PM
 */

namespace PhpBootstrap\Contracts;

use Psr\Http\Message\ResponseInterface;

interface Response extends ResponseInterface
{
    /**
     * Generates a response with custom code HTTP header and a given message.
     *
     * @param $message
     * @param $code
     * @param array $headers
     * @return mixed
     */
    public function withError($message, $code, array $headers = []);

    /**
     * Generates a response with a 403 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorForbidden($message = '', array $headers = []);

    /**
     * Generates a response with a 500 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorInternalError($message = '', array $headers = []);

    /**
     * Generates a response with a 404 HTTP header and a given message.
     *
     * @param string $message
     * @param array  $headers
     * @return mixed
     */
    public function errorNotFound($message = '', array $headers = []);
}