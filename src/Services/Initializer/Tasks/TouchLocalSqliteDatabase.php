<?php

namespace Meowstic\Services\Initializer\Tasks;

use Meowstic\Task\Task;

class TouchLocalSqliteDatabase extends Task
{
    public function run()
    {
        //

        $files = [
            'app/config/database.php',
            'config/database.php',
        ];

        foreach ($files as $file) {
            if (!$this->exists($file)) {
                continue;
            }

            $data = require $file;

            if (!is_array($data)) {
                continue;
            }

            foreach ($data['connections'] as $connection) {
                if ($connection['driver'] !== 'sqlite') {
                    continue;
                }

                echo $connection['database'];
            }

            break;
        }
        // app/config/database.php
    }
}
