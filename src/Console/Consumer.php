<?php
/**
 * @author    Harry Osmar Sitohang <hsitohang@wayfair.com>
 * @copyright 2019 Wayfair LLC - All rights reserved
 */

namespace PhpBootstrap\Console;

use Kafka\ConsumerConfig;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Consumer extends Command {
  protected function configure() {
    $this->setName('kafka:consumer')
        ->setDescription('start kafka worker/consumer')
        ->setHelp('Waiting for message from kafka broker to be consumed');
  }

  /**
   * @param InputInterface  $input
   * @param OutputInterface $output
   *
   * @return int|null|void
   * @throws \Exception
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $logger = new Logger('my_logger');
    $logger->pushHandler(new StreamHandler('/var/www/log/consumer.log', Logger::DEBUG));

    $config = ConsumerConfig::getInstance();
    $config->setMetadataRefreshIntervalMs(10000);
    $config->setMetadataBrokerList('kafka:9092');
    $config->setGroupId('test');
    $config->setBrokerVersion('1.0.0');
    $config->setTopics(['test']);
    $consumer = new \Kafka\Consumer();

    $consumer->setLogger($logger);

    $output->writeln('Listening for message');

    $consumer->start(
        function ($topic, $part, $message) use ($output) {
          $output->writeln($message);
        }
    );
  }
}