<?php

namespace Meowstic\Services\Converter\Tasks;

use Meowstic\Task\Task;

class MoveAppToSrc extends Task
{
    public function run()
    {
        rename(
            ($this->getPath() . DIRECTORY_SEPARATOR . 'app'),
            ($this->getPath() . DIRECTORY_SEPARATOR . 'src')
        );
    }
}
