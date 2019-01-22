<?php
/**
 * Created by PhpStorm.
 * User: harry
 * Date: 2/12/18
 * Time: 4:11 PM
 */

namespace PhpBootstrap\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloWorld extends Command
{
    protected function configure()
    {
        $this->setName('app:helloworld')
            ->setDescription('testing redis by set new key `hello-world`.')
            ->setHelp('This command only for testing...');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Trying `to greet` the world',
            '============',
        ]);

        // outputs a message followed by a "\n"
        $output->writeln('Great the world `accept you`');
    }
}