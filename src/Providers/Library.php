<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/15/18
 * Time: 12:48 PM
 */

namespace PhpBootstrap\Providers;

use FluentPDO;
use League\Container\ServiceProvider\AbstractServiceProvider;
use PDO;
use PhpBootstrap\Services\Hello;
use PhpBootstrap\Contracts\Response as ResponseInterface;
use Zend\Config\Config;
use Zend\Diactoros\ServerRequestFactory;
use PhpBootstrap\Services\Response;

/**
 * Class ServiceProviders
 * @package PhpBootstrap
 * All your library/services need to be registered in the container
 */
class Library extends AbstractServiceProvider
{
    protected $provides = [
        ResponseInterface::class,
        'request',
        'emitter',
        \PhpBootstrap\Contracts\Hello::class
    ];

    /**
     * register all your library to DI container
     */
    public function register()
    {
        $this->getContainer()->share(ResponseInterface::class, Response::class);

        $this->getContainer()->share(
            'request',
            function () {
                return ServerRequestFactory::fromGlobals();
            }
        );

        $this->getContainer()->share('emitter', \Zend\Diactoros\Response\SapiEmitter::class);

        // by registering the helloworld implementation as an alias of it's interface it
        // is easy to swap out for other implementations
        $this->getContainer()
            ->add(\PhpBootstrap\Contracts\Hello::class, Hello::class);

        /**
         * Config
         */
        $this->getContainer()
            ->share('config', function() {
                return new Config(require_once implode(DIRECTORY_SEPARATOR, [dirname(__FILE__), '..', 'config.php']));
            });

        /**
         * PDO MySQL
         */
        $this->getContainer()->share('pdo', function() {
            /** @var Config $config */
            $config = $this->getContainer()->get('config');

            $pdo = new PDO(
                sprintf(
                    "%s:dbname=%s;host=%s;port=%d",
                    $config->database->adapter,
                    $config->database->params->dbname,
                    $config->database->params->host,
                    $config->database->params->port
                ),
                $config->database->params->username,
                $config->database->params->password
            );

            return new FluentPDO($pdo);
        });
    }
}