<?php

namespace Meowstic\Services\Converter\Tasks;

use Meowstic\Task\Task;

class CreateAndMoveDirectoriesToApp extends Task
{
    public function run()
    {
        mkdir($this->getPath() . DIRECTORY_SEPARATOR . 'app');

        $directories = [
            'bootstrap',
            'config',
            'database',
            'resources',
            'routes',
            'storage',
        ];

        foreach ($directories as $directory) {
            rename(
                ($this->getPath() . DIRECTORY_SEPARATOR . $directory),
                ($this->getPath() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $directory)
            );
        }
    }
}
