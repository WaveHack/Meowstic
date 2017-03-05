<?php

namespace Meowstic\Commands;

use Meowstic\Services\Converter\ConverterService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ConvertCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('convert')
            ->setDescription('Converts a Laravel project\'s directory structure')
            ->setDefinition(new InputDefinition([
                new InputOption('dry', 'd', InputOption::VALUE_NONE, 'Dry run')
            ]));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $converter = (new ConverterService($input, $output))
            ->setPath(getcwd())
            ->setDryRun($input->getOption('dry'));

        $converter->convert();
    }
}
