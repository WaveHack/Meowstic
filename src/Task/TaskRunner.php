<?php

namespace Meowstic\Task;

use Meowstic\Traits\PathAwareTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TaskRunner
{
    use PathAwareTrait;

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var Task[]
     */
    protected $tasks = [];

    /**
     * @var bool
     */
    protected $dryRun = false;

    /**
     * TaskRunner constructor.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * @param Task|Task[] $tasks
     * @return $this
     */
    public function add($tasks)
    {
        if (is_array($tasks)) {
            foreach ($tasks as $task) {
                $this->add($task);
            }
        } else {
            $tasks->setTaskRunner($this);
            $this->tasks[] = $tasks;
        }

        return $this;
    }

    public function run()
    {
        foreach ($this->tasks as $task) {
            $className = (new \ReflectionClass($task))->getShortName();

            if (!$task->check()) {
                $this->getOutput()->writeln("<comment>Skipping task {$className}</comment>", OutputInterface::VERBOSITY_VERBOSE);
                continue;
            }

            $this->getOutput()->writeln("<info>Executing task {$className}</info>", OutputInterface::VERBOSITY_VERBOSE);

            $task->run();
        }
    }

    /**
     * @return InputInterface
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @return OutputInterface
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @return bool
     */
    public function isDryRun()
    {
        return $this->dryRun;
    }

    /**
     * @param bool $dryRun
     */
    public function setDryRun($dryRun)
    {
        $this->dryRun = $dryRun;
    }
}
