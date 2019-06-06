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
    $rk = new \RdKafka\Producer();

    $rk->setLogLevel(LOG_DEBUG);
    $rk->addBrokers('kafka:9092');

    $topic = $rk->newTopic('test');

    for ($i = 0; $i < 10; $i++) {
      $topic->produce(RD_KAFKA_PARTITION_UA, 0, "Message $i");
      $rk->poll(0);
    }

    while ($rk->getOutQLen() > 0) {
      $rk->poll(50);
    }
  }
}