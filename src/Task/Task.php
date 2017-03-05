<?php

namespace Meowstic\Task;

use Meowstic\Traits\PathAwareTrait;

abstract class Task
{
    use PathAwareTrait;

    public abstract function run();
}
