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

## Web Doc

- [intro](https://github.com/harryosmar/php-bootstrap/blob/queue-rabbitmq/web.md)
- [doc](https://github.com/harryosmar/php-bootstrap/blob/queue-rabbitmq/doc.md)