<?php

namespace Meowstic\Services;

use Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConverterService
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var bool
     */
    protected $dryRun = false;

    public function convert()
    {
        if (!$this->isEligibleForConversion()) {
            throw new Exception;
        }

        // create bin
        // mv artisan to bin

        // mv app to src

        // create app
        // mv bootstrap to app
        // mv config to app
        // mv database to app
        // mv resources to app
        // mv routes to app
        // mv storage to app

        // fix app/bootstrap/app.php
        // fix app/bootstrap/autoload.php
        // fix app/config/view.php
        // fix bin/artisan
        // fix src/Console/Kernel.php
        // fix src/Providers/BroadcastServiecProvider.php
        // fix src/Providers/RouteServiecProvider.php

        // fix composer.json
    }

    /**
     * @return bool
     */
    public function isLaravelProject()
    {
        $composerJsonFile = ($this->path . DIRECTORY_SEPARATOR . 'composer.json');

        if (!file_exists($composerJsonFile)) {
            return false;
        }

        $composerData = json_decode(file_get_contents($composerJsonFile), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        $require = array_keys($composerData['require']);

        if (!in_array('laravel/framework', $require, true)) {
            return false;
        }

        // todo: additional checks?

        return true;
    }

    /**
     * @return bool
     */
    public function isEligibleForConversion()
    {
        $checkExists = [
            'app',
            'bootstrap',
            'config',
            'database',
            'resources',
            'storage',
            'routes',
        ];

        $checkDontExists = [
            'app/Application.php',
            'bin',
            'src',
        ];

        foreach ($checkExists as $path) {
            if (!file_exists($this->path . DIRECTORY_SEPARATOR . $path)) {
                return false;
            }
        }

        foreach ($checkDontExists as $path) {
            if (file_exists($this->path . DIRECTORY_SEPARATOR . $path)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @param bool $dryRun
     * @return $this
     */
    public function setDryRun($dryRun)
    {
        $this->dryRun = $dryRun;
        return $this;
    }
}
