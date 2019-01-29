<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/13/18
 * Time: 1:15 PM
 */

namespace PhpBootstrap\Services;

use PhpBootstrap\Contracts\Response as ResponseInterface;
use Zend\Diactoros\MessageTrait;
use Zend\Diactoros\Response\InjectContentTypeTrait;

/**
 * Class Response
 * @package PhpBootstrap\Services
 * Just extend the \PhpRestfulApiResponse\Response from https://github.com/harryosmar/php-restful-api-response
 */
class Response extends \PhpRestfulApiResponse\Response implements ResponseInterface
{
    use MessageTrait, InjectContentTypeTrait;

    /**
     * Response constructor.
     * @param string $body
     * @param int $status
     * @param int $errorCode
     * @param array $headers
     */
    public function __construct($body = 'php://memory', int $status = 200, $errorCode = null, array $headers = [])
    {
        $this->setStatusCode($status);
        $this->setErrorCode($errorCode);
        $this->stream = $this->getStream($body, 'wb+');
        $this->setHeaders($this->headers);
    }

    /**
     * @return Response
     */
    public function asJSON() : ResponseInterface
    {
        $headers = $this->injectContentType('application/json', $this->headers);
        $this->setHeaders($headers);

        return $this;
    }

    /**
     * @return Response
     */
    public function asHTML() : ResponseInterface
    {
        $headers = $this->injectContentType('text/html', $this->headers);
        $this->setHeaders($headers);

        return $this;
    }
}