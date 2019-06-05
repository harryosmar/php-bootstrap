<?php
/**
 * @author    Harry Osmar Sitohang <hsitohang@wayfair.com>
 * @copyright 2019 Wayfair LLC - All rights reserved
 */

namespace PhpBootstrap\Console;

use Kafka\ProducerConfig;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Producer extends Command {
  protected function configure() {
    $this->setName('kafka:producer')
        ->setDescription('start kafka producer')
        ->setHelp('kafka producer connect-to/create a topic, then publish message to the topic');
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
    $logger->pushHandler(new StreamHandler('/var/www/log/producer.log', Logger::DEBUG));

    $config = ProducerConfig::getInstance();
    $config->setMetadataRefreshIntervalMs(10000);
    $config->setMetadataBrokerList('kafka:9092');
    $config->setBrokerVersion('1.0.0');
    $config->setRequiredAck(1);
    $config->setIsAsyn(false);
    $config->setProduceInterval(500);

    $producer = new \Kafka\Producer(
        function () {
          return [
              [
                  'topic' => 'test',
                  'value' => 'test....message.',
                  'key'   => 'testkey',
              ],
          ];
        }
    );

    $producer->setLogger($logger);

    $producer->success(
        function ($result) use ($output) {
          $output->writeln('SUCCESS:' . print_r($result, true));
        }
    );

    $producer->error(
        function ($errorCode) use ($output) {
          $output->writeln('ERROR:' . $errorCode);
        }
    );

    $producer->send(true);
  }
}