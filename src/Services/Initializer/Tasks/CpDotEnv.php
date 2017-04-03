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

        $envFilesToCheck = [
            ".env.template.{$env}",
            '.env.example', // Laravel default
        ];

        foreach ($envFilesToCheck as $envFile) {
            if ($this->exists($envFile)) {
                $this->exec("cp {$envFile} .env");
                break;
            }
        }
    }
}
