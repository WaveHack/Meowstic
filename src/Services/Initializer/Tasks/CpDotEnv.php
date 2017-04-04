<?php

namespace Meowstic\Services\Initializer\Tasks;

use Meowstic\Task\Task;

class CpDotEnv extends Task
{
    public function check()
    {
         return !$this->exists('.env');
    }

    public function run()
    {
        $env = $this->getTaskRunner()->getInput()->getArgument('env');

        $files = [
            ".env.template.{$env}",
            '.env.example', // Laravel default
        ];

        foreach ($files as $file) {
            if (!$this->exists($file)) {
                continue;
            }

            $this->exec("cp {$file} .env");
            break;
        }
    }
}
