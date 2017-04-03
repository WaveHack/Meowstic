<?php

namespace Meowstic\Services\Initializer\Tasks;

use Meowstic\Task\Task;

class ComposerInstall extends Task
{
    public function check()
    {
        return (
            $this->exists('composer.json')
            && !$this->exists('vendor')
        );
    }

    public function run()
    {
        $env = $this->getTaskRunner()->getInput()->getArgument('env');

        $args = [
            '--no-interaction',
        ];

        if ($env === 'production') {
            $args[] = '--prefer-dist';
            $args[] = '--no-dev';
        } else {
            $args[] = '--prefer-source';
        }

        $this->exec('composer install ' . implode(' ', $args));
    }
}
