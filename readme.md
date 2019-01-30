# Messaging
* [Simple Messaging](https://github.com/harryosmar/php-bootstrap/blob/simple-rabbitmq/readme.md)
* [Works Queues](https://github.com/harryosmar/php-bootstrap/blob/queue-rabbitmq/readme.md)

![publisher & multipe consumer](https://github.com/harryosmar/php-bootstrap/blob/queue-rabbitmq/public/images/queue-multi-workers.jpg)

## Setup

```
git clone --single-branch --branch simple-rabbitmq git@github.com:harryosmar/php-bootstrap.git
composer install
docker-compose up
```

## Simple RabbitMQ Message-Broker Flow

```
channel > queue > publish/consume message
```

Pre-Steps :
1. create `AMQPStreamConnection`
2. create connection `channel`


`Publish` steps:
1. declare `queue`
2. `publish` message to declared `queue`
3. close `channel`
4. close `AMQPStreamConnection`

`Consume` steps:
1. declare `queue`
2. `consume` message, with `n` seconds sleep time
3. `channel` waiting... for another incoming message

Check the actual code of [`RabbitMQMessagingSystem.php`](https://github.com/harryosmar/php-bootstrap/blob/queue-rabbitmq/src/Services/RabbitMQMessagingSystem.php)

## How to use

### start publisher

[`Publisher.php`](https://github.com/harryosmar/php-bootstrap/blob/queue-rabbitmq/src/Console/Messaging/Publisher.php)

```
php console.php app:message:publish <data>
```

eq : `php console.php app:message:publish "A very hard task which takes two seconds.."`

output

```
[x] Sent <data>
```

### start consumer

[`Consumer.php`](https://github.com/harryosmar/php-bootstrap/blob/queue-rabbitmq/src/Console/Messaging/Consumer.php)

Repeat this command for creating a new `consumer`

```
php console.php app:message:consume
```

output

```
[*] Waiting for messages. To exit press CTRL+C\n
[*] Received A very hard task which takes two seconds..
[*] Done
```

### Round-robin dispatching

- By default, `RabbitMQ` will send each message to the next consumers in `sequence`,
- On average each consumer will get the `same number` of messages.
- This way of distributing is called `round-robin`.


### Message acknowledgment/ack

Without using `ack` :
- When the `worker/consumer` is dies, while processing the message or the `worker/consumer` is terminated, then we will *lose* the all the messages, which has been `dispatched` to this `worker/consumer`, but *not yet* `handled/processed`.
- When `RabbitMQ` delivered message to `worker/consumer`, then the message immediately *marked* for `deletion`.

With `ack`
- `ack` will be sent by `consumer/worker` that the message has been `received` and `processed`. So the message it's free for `deletion`.
- When `worker/consumer` is dies (connection, channel is closed), *without `ack` from `worker/consumer`*, all the messages that has been `dispatched` to that `worker/consumer`, will be `re-queued`. Later the message can be `dispatched` to another `worker/consumer`. 

> Message acknowledgments are `turned off` by default.

Change from
```php
<?php
$channel->basic_consume('task_queue', '', false, true, false, false, $callback);
```

to 

```php
<?php
$channel->basic_consume('task_queue', '', false, false, false, false, $callback);
```

> `ack` must be sent on the same `channel` the `delivery` it is === for `was received on`. If not it will result in a `channel-level protocol exception`


### Queue Durability

> What will happened when `RabbitMQ` server is restart ?

> Problems occured :

- Even we already enabled `ack` in `worker/consumer` side. We still lose all the `messages`, `queues`.

> Solution : 

enabled [`queue durable`](#queue-durability) and  [`Message Persistence`](#message-persistence)

- The existing `queue` can not be switched from from `durable` off to on.
- This flag set `durable` to `true` needs to be applied to both the [`producer`](https://github.com/harryosmar/php-bootstrap/blob/queue-rabbitmq/src/Console/Messaging/Publisher.php) and [`consumer`](https://github.com/harryosmar/php-bootstrap/blob/queue-rabbitmq/src/Console/Messaging/Consumer.php).

### Message Persistence

- It's means the `message` will be saved/stored in `disk`.
- But It's not fully guarantee that the `messages` won't be loss, because there is still `time window`, when `RabbitMQ` *received* the message, but *not yet* `save/store` it in the `disk.`

```php
<?php
use PhpAmqpLib\Message\AMQPMessage;

$msg = new AMQPMessage(
    $data,
    array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
);
```

### Fair dispatch

> Problem : In case if there is a 2 `worker/consumer`, where the odd `messages` is `heavy` and the even `messages` is `light`. This will make the 1st worker busy handle the `heavy` messages.

> Why this is happened ?

- Because `rabbit mq` use [Round-robin dispatching](#round-robin-dispatching),
- `RabbitMQ` *blindly* `dispatch` `message` to a `consumer`, without checking the number of `unacknowledged messages`/`unprocessed message` for that `consumer`.

> Solution

- 1 `worker` only handle 1 `message` at a time.
- `RabbitMQ` will not `dispatch` a new message to a `consumer`, if `consumer` still has `unacknowledged message`.

```php
<?php
$channel->basic_qos(null, 1, null);
```

> Trade off for the solution above

- This could make the `queue` fill up, if all the `workers/consumer` is busy. Solution for this can be : adding more `workers/consumer`.

## Web Doc

- [intro](https://github.com/harryosmar/php-bootstrap/blob/queue-rabbitmq/web.md)
- [doc](https://github.com/harryosmar/php-bootstrap/blob/queue-rabbitmq/doc.md)