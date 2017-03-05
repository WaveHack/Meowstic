<?php

namespace Meowstic\Services\Converter;

class Checker
{
    /**
     * @var ConverterService
     */
    protected $converter;

    /**
     * Checker constructor.
     *
     * @param ConverterService $converter
     */
    public function __construct(ConverterService $converter)
    {
        $this->converter = $converter;
    }

    /**
     * @return bool
     */
    public function isLaravelProject()
    {
        $composerJsonFile = ($this->converter->getPath() . DIRECTORY_SEPARATOR . 'composer.json');

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
            if (!file_exists($this->converter->getPath() . DIRECTORY_SEPARATOR . $path)) {
                return false;
            }
        }

        foreach ($checkDontExists as $path) {
            if (file_exists($this->converter->getPath() . DIRECTORY_SEPARATOR . $path)) {
                return false;
            }
        }

        return true;
    }
}
