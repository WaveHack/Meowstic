<?php

namespace Meowstic\Commands;

use Exception;
use Meowstic\Services\ConverterService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

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
        $helper = $this->getHelper('question');

        $converter = new ConverterService;
        $converter->setPath(getcwd());
        $converter->setDryRun($input->getOption('dry'));

        $output->writeln('<info>Checking for Laravel project</info>', OutputInterface::VERBOSITY_VERBOSE);

        if (!$converter->isLaravelProject()) {
            throw new Exception('Not a Laravel project');
        }

        $output->writeln('<info>Checking if project is eligible for conversion</info>', OutputInterface::VERBOSITY_VERBOSE);

        if (!$converter->isEligibleForConversion()) {
            throw new Exception('Project not eligible for conversion. Already converted or non-supported structure');
        }






        $question = new ConfirmationQuestion('Continue convert? [yN]: ', false);

        if (!$helper->ask($input, $output, $question)) {
            return;
        }

        $output->writeln('<info>Converting project</info>');

        $converter->convert();
    }
}
