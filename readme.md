# Messaging
* [Simple Messaging](https://github.com/harryosmar/php-bootstrap/blob/simple-rabbitmq/readme.md)
* [Works Queues](https://github.com/harryosmar/php-bootstrap/blob/queue-rabbitmq/readme.md)

![publisher & multipe consumer](https://github.com/harryosmar/php-bootstrap/blob/simple-rabbitmq/public/images/simple-queue.v1.jpg)

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
2. `consume` message
3. `channel` waiting... for another incoming message

Check the actual code of [`RabbitMQMessagingSystem.php`](https://github.com/harryosmar/php-bootstrap/blob/simple-rabbitmq/src/Services/RabbitMQMessagingSystem.php)

## How to use

### start publisher

[`Publisher.php`](https://github.com/harryosmar/php-bootstrap/blob/simple-rabbitmq/src/Console/Messaging/Publisher.php)

```
php console.php app:message:publish
```

output

```
[x] Sent 'Hello World!
```

### start consumer

[`Consumer.php`](https://github.com/harryosmar/php-bootstrap/blob/simple-rabbitmq/src/Console/Messaging/Consumer.php)

```
php console.php app:message:consume
```

output

```
[*] Waiting for messages. To exit press CTRL+C\n
[*] Received Hello World!
```

## Web Doc

- [intro](https://github.com/harryosmar/php-bootstrap/blob/simple-rabbitmq/web.md)
- [doc](https://github.com/harryosmar/php-bootstrap/blob/simple-rabbitmq/doc.md)