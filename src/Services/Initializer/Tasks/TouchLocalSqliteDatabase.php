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

            $data = file_get_contents($file);

            if (preg_match('/^\s+\'database\' => (.*?)\'(\w+\.sqlite)\'.*?,$/m', $data, $matches)) {

                $filename = $matches[2];

                if (strpos($matches[1], 'storage_path') !== false) {

                } elseif (strpos($matches[1], 'database_path') !== false) {

                }


                var_dump($matches);
            }

            break;
        }
        // app/config/database.php
    }
}
