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
    $conf = new \RdKafka\Conf();

    // Set a rebalance callback to log partition assignments (optional)
    $conf->setRebalanceCb(function (\RdKafka\KafkaConsumer $kafka, $err, array $partitions = null) use ($output) {
      switch ($err) {
        case RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS:
          $output->write('Assign: ');
          $output->writeln(print_r($partitions, true));
          $kafka->assign($partitions);
          break;

        case RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS:
          $output->write('Revoke: ');
          $output->writeln(print_r($partitions, true));
          $kafka->assign(NULL);
          break;

        default:
          throw new \Exception($err);
      }
    });

    // Configure the group.id. All consumer with the same group.id will consume
    // different partitions.
    $conf->set('group.id', 'myConsumerGroup');

    // Initial list of Kafka brokers
    $conf->set('metadata.broker.list', 'kafka:9092');

    $topicConf = new \RdKafka\TopicConf();


    // Set where to start consuming messages when there is no initial offset in
    // offset store or the desired offset is out of range.
    // 'smallest': start from the beginning
    $topicConf->set('auto.offset.reset', 'smallest');

    // Set the configuration to use for subscribed/assigned topics
    $conf->setDefaultTopicConf($topicConf);

    $consumer = new \RdKafka\KafkaConsumer($conf);

    // Subscribe to topic 'test'
    $consumer->subscribe(['test']);

    $output->write('Waiting for partition assignment... (make take some time when');
    $output->writeln('quickly re-joining the group after leaving it.)');

    while (true) {
      $message = $consumer->consume(120*1000);
      switch ($message->err) {
        case RD_KAFKA_RESP_ERR_NO_ERROR:
          $output->writeln($message);
          break;
        case RD_KAFKA_RESP_ERR__PARTITION_EOF:
          $output->writeln('No more messages; will wait for more');
          break;
        case RD_KAFKA_RESP_ERR__TIMED_OUT:
          $output->writeln('Timed out');
          break;
        default:
          throw new \Exception($message->errstr(), $message->err);
          break;
      }
    }
  }
}