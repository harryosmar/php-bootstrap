<?php
/**
 * Created by PhpStorm.
 * User: harryosmar
 * Date: 1/28/19
 * Time: 11:21 PM
 */

namespace PhpBootstrap\Services;


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpBootstrap\Contracts\MessagingSystem;

class RabbitMQMessagingSystem implements MessagingSystem
{
    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    /**
     * @var AMQPChannel
     */
    private $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(getenv('MESSAGING_HOST'), getenv('MESSAGING_PORT'), getenv('MESSAGING_USERNAME'), getenv('MESSAGING_PASS'));
        $this->channel = $this->connection->channel();
    }


    public function publish(string $queueName, string $message)
    {
        $this->channel->queue_declare($queueName, false, false, false, false);
        $msg = new AMQPMessage($message);
        $this->channel->basic_publish($msg, '', 'hello');
        $this->channel->close();
        $this->connection->close();
    }

    public function consume(string $queueName, \Closure $closure)
    {
        $this->channel->queue_declare($queueName, false, false, false, false);

        /** @var AMQPMessage $msg */
        $callback = function ($msg) use ($closure) {
            $closure->call($this, $msg);
        };

        $this->channel->basic_consume($queueName    , '', false, true, false, false, $callback);

        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }
}