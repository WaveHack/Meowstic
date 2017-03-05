<?php

namespace Meowstic\Services\Converter\Tasks;

use Meowstic\Task\Task;

class ComposerDumpAutoload extends Task
{
    public function run()
    {
        shell_exec("cd {$this->getPath()} && composer dump-autoload");
    }
}
