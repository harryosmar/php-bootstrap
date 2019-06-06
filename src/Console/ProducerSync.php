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

class ProducerSync extends Command {
  protected function configure() {
    $this->setName('kafka:producer-sync')
        ->setDescription('start kafka producer synchronous')
        ->setHelp('kafka producer-sync connect-to/create a topic, then publish messages to the topic');
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
    $logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));

    $config = ProducerConfig::getInstance();
    $config->setMetadataRefreshIntervalMs(10000);
    $config->setMetadataBrokerList('kafka:9092');
    $config->setBrokerVersion('1.0.0');
    $config->setRequiredAck(1);
    $config->setIsAsyn(false);
    $config->setProduceInterval(500);
    $producer = new \Kafka\Producer();
    $producer->setLogger($logger);

    for ($i = 0; $i < 100; $i++) {
      $producer->send(
          [
              [
                  'topic' => 'test',
                  'value' => 'test0....sync...message.' . $i,
                  'key'   => '',
                  'partId' => rand(0, 1)
              ],
          ]
      );
    }
  }
}