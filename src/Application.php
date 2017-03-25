<?php

namespace Meowstic;

use Meowstic\Commands\ConvertCommand;
use Symfony\Component\Console\Application as SymfonyApplication;

class Application extends SymfonyApplication
{
    const NAME = 'Meowstic';
    const VERSION = '0.1.13';

    public function __construct()
    {
        parent::__construct(static::NAME, static::VERSION);

        $this->add(new ConvertCommand);
    }
}
