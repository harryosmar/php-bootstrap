<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/13/18
 * Time: 2:11 PM
 */

namespace PhpBootstrap\Contracts;

use PhpRestfulApiResponse\Contracts\PhpRestfulApiResponse;

/**
 * Interface Response
 * @package PhpBootstrap\Contracts
 * We just extend the \PhpRestfulApiResponse\Contracts\PhpRestfulApiResponse from https://github.com/harryosmar/php-restful-api-response
 * You can add new response method or override the existing method here as you wish
 */
interface Response extends PhpRestfulApiResponse
{

}