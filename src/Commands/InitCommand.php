<?php

namespace Meowstic\Commands;

use Meowstic\Services\Initializer\InitializerService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InitCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('init')
            ->setDescription('Initializes a freshly Git-cloned Laravel project')
            ->setDefinition(new InputDefinition([
                new InputOption('path', null, InputOption::VALUE_OPTIONAL, 'Path to use. Default is current working directory'),
                new Inputoption('dry-run', 'd', InputOption::VALUE_NONE, 'Dry run (do not execute commands)'),

                new InputArgument('env', InputArgument::OPTIONAL, 'Environment to use', 'local'),
                new InputArgument('branch', InputArgument::OPTIONAL, 'Git branch to use', 'master'),
            ]));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return (new InitializerService($input, $output))
            ->init();
    }
}
