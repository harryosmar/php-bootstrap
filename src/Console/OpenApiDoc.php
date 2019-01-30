<?php
/**
 * @author    Harry Osmar Sitohang <hsitohang@wayfair.com>
 * @copyright 2018 Wayfair LLC - All rights reserved
 */

namespace PhpBootstrap\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function OpenApi\scan;

class OpenApiDoc extends Command {
  protected function configure()
  {
    $this->setName('app:open.api.doc:generate')
        ->setDescription('Generate open api doc in swagger yml format')
        ->setHelp('...');
  }

  /**
   * @param InputInterface $input
   * @param OutputInterface $output
   * @return int|null|void
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $openapi = scan(implode(DIRECTORY_SEPARATOR, [dirname(__FILE__), '..', '..', 'src']));
    header('Content-Type: application/x-yaml');
    echo $openapi->toYaml();
  }
}