<?php

namespace Meowstic\Task;

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

        passthru("cd {$this->getPath()} && {$cmd}", $returnVar);
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
