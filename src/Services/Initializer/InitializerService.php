<?php

namespace Meowstic\Services\Initializer;

use Meowstic\Services\Initializer\Tasks\ComposerInstall;
use Meowstic\Services\Initializer\Tasks\CpDotEnv;
use Meowstic\Services\Service;
use Meowstic\Task\TaskRunner;
use Meowstic\Traits\PathAwareTrait;

class InitializerService extends Service
{
    use PathAwareTrait;

    public function init()
    {
        if (($path = $this->input->getOption('path')) !== null) {
            $this->setPath($path);
        } else {
            $this->setPath(getcwd());
        }

        $taskRunner = (new TaskRunner($this->input, $this->output))
            ->setPath($this->getPath())
            ->add([
                // PHP
                new ComposerInstall,

                // Laravel
                new CpDotEnv,
//                new TouchLocalSqliteDatabase,
//                new ArtisanKeyGenerate,
//                new LaravelIdeHelpers,

                // Frontend
                // npm/yarn install
                // bower install
                // npm run dev/production OR gulp

                // Testing
                // laravel-mix version assets for testing

                // Production
                // production msg
            ]);

        $taskRunner->run();
    }
}
