<?php

namespace Meowstic\Task;

use Meowstic\Traits\PathAwareTrait;

class TaskRunner
{
    use PathAwareTrait;

    /**
     * @var Task[]
     */
    protected $tasks;

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
            $tasks->setPath($this->getPath());
            $this->tasks[] = $tasks;
        }

        return $this;
    }

    public function run()
    {
        foreach ($this->tasks as $task) {
            $task->run();
        }
    }
}
