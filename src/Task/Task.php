<?php

namespace Meowstic\Task;

use Symfony\Component\Console\Output\OutputInterface;

abstract class Task
{
    /**
     * @var TaskRunner
     */
    private $taskRunner;

    /**
     * @return bool
     */
    public function check()
    {
        return true;
    }

    abstract public function run();

    public function exists($path)
    {
        return file_exists($this->getPath() . DIRECTORY_SEPARATOR . $path);
    }

    /**
     * @param string $cmd
     * @return int|null
     */
    public function exec($cmd)
    {
        $this->taskRunner->getOutput()->writeln("{$cmd}");

        if ($this->taskRunner->isDryRun()) {
            return null;
        }

        $cmd = "cd {$this->getPath()} && {$cmd}";

        passthru($cmd, $returnVar);
        return $returnVar;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->taskRunner->getPath();
    }

    /**
     * @return TaskRunner
     */
    public function getTaskRunner()
    {
        return $this->taskRunner;
    }

    /**
     * @param mixed $taskRunner
     * @return $this
     */
    public function setTaskRunner($taskRunner)
    {
        $this->taskRunner = $taskRunner;
        return $this;
    }
}
