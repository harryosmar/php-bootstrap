<?php
/**
 * Created by PhpStorm.
 * User: harryosmar
 * Date: 1/28/19
 * Time: 11:30 PM
 */

namespace PhpBootstrap\Console\Messaging;


use League\Container\Container;
use PhpBootstrap\Contracts\MessagingSystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Publisher extends Command
{
    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
        parent::__construct(null);
    }


    protected function configure()
    {
        $this->setName('app:message:publish')
            ->setDescription('messaging system publisher');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var MessagingSystem $messagingSystem */
        $messagingSystem = $this->container->get(MessagingSystem::class);

        $messagingSystem->publish('hello', 'Hello World!');

        $output->writeln([
            '[x] Sent \'Hello World!',
        ]);
    }
}