<?php

namespace Meowstic\Services\Converter;

use Meowstic\Services\Converter\Exceptions\NotALaravelProjectException;
use Meowstic\Services\Converter\Exceptions\NotEligibleForConversionException;
use Meowstic\Services\Converter\Tasks\ComposerDumpAutoload;
use Meowstic\Services\Converter\Tasks\CreateAndMoveDirectoriesToApp;
use Meowstic\Services\Converter\Tasks\CreateApplicationClass;
use Meowstic\Services\Converter\Tasks\FixPaths;
use Meowstic\Services\Converter\Tasks\MoveAppToSrc;
use Meowstic\Services\Converter\Tasks\MoveArtisanToBin;
use Meowstic\Task\TaskRunner;
use Meowstic\Traits\PathAwareTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConverterService
{
    use PathAwareTrait;

    /**
     * @var Checker
     */
    protected $checker;

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var bool
     */
    protected $dryRun = false;

    /**
     * ConverterService constructor.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->checker = new Checker($this);
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * @throws NotALaravelProjectException
     * @throws NotEligibleForConversionException
     */
    public function convert()
    {
        if ($this->getPath() === null) {
            $this->setPath(getcwd());
        }

        $this->output->writeln('<info>Checking for Laravel project</info>', OutputInterface::VERBOSITY_VERBOSE);

        if (!$this->checker->isLaravelProject()) {
            throw new NotALaravelProjectException;
        }

        $this->output->writeln('<info>Checking if project is eligible for conversion</info>', OutputInterface::VERBOSITY_VERBOSE);

        if (!$this->checker->isEligibleForConversion()) {
            throw new NotEligibleForConversionException;
        }

        $this->output->writeln('<info>Converting project</info>');

        $taskRunner = (new TaskRunner)
            ->setPath($this->getPath())
            ->add([
                new MoveArtisanToBin,
                new MoveAppToSrc,
                new CreateAndMoveDirectoriesToApp,
                new CreateApplicationClass,
                new FixPaths,
                new ComposerDumpAutoload,
            ]);

        $taskRunner->run();

        $this->output->writeln('<info>Done converting project</info>');
    }

    /**
     * @param bool $dryRun
     * @return $this
     */
    public function setDryRun($dryRun)
    {
        $this->dryRun = $dryRun;
        return $this;
    }
}
