<?php

namespace Meowstic;

use Meowstic\Commands\ConvertCommand;
use Meowstic\Commands\InitCommand;
use Symfony\Component\Console\Application as SymfonyApplication;

class Application extends SymfonyApplication
{
    const NAME = 'Meowstic';
    const VERSION = '1.0';

    public function __construct()
    {
        parent::__construct(static::NAME, static::VERSION);

        $this->add(new ConvertCommand);
        $this->add(new InitCommand);
    }
}
