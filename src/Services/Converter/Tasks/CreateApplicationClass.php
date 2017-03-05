<?php

namespace Meowstic\Services\Converter\Tasks;

use Meowstic\Task\Task;
use Meowstic\Traits\NamespaceAwareTrait;

class CreateApplicationClass extends Task
{
    use NamespaceAwareTrait;

    public function run()
    {
        $path = ($this->getPath() . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Application.php');

        if (file_exists($path)) {
            return;
        }

        $stub = file_get_contents(__DIR__ . '/../stubs/Application.stub');

        $stub = str_replace(
            '{{namespace}}',
            $this->getNamespace(),
            $stub
        );

        file_put_contents($path, $stub);
    }
}
