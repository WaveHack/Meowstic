<?php

namespace Meowstic\Services\Converter\Tasks;

use Meowstic\Task\Task;

class MoveArtisanToBin extends Task
{

    public function run()
    {
        mkdir($this->getPath() . DIRECTORY_SEPARATOR . 'bin');

        rename(
            ($this->getPath() . DIRECTORY_SEPARATOR . 'artisan'),
            ($this->getPath() . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'artisan')
        );
    }
}
