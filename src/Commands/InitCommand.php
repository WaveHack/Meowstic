<?php

namespace Meowstic\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('init')
            ->addArgument('env', InputArgument::REQUIRED, 'env desc here')
            ->setDescription('description here')
            ->setHelp('help here');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>meow! :3</info>');
    }
}
