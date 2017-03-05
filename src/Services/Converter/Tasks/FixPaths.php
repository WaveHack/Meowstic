<?php

namespace Meowstic\Services\Converter\Tasks;

use Meowstic\Task\Task;
use Meowstic\Traits\NamespaceAwareTrait;

class FixPaths extends Task
{
    use NamespaceAwareTrait;

    public function run()
    {
        $this->fixAppBootstrapApp();
        $this->fixAppBootstrapAutoload();
        $this->fixAppConfigView();
        $this->fixBinArtisan();
        $this->fixSrcConsoleKernel();
        $this->fixSrcProvidersBroadcastServiceProvider();
        $this->fixSrcProvidersRouteServiceProvider();
        $this->fixComposerJson();
    }

    protected function fixAppBootstrapApp()
    {
        $path = ($this->getPath() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'bootstrap' . DIRECTORY_SEPARATOR . 'app.php');

        if (!file_exists($path)) {
            return;
        }

        $applicationFCQN = ($this->getNamespace() . '\Application');

        $data = file_get_contents($path);

        $data = preg_replace('/new Illuminate\\\Foundation\\\Application/', ('new ' . $applicationFCQN), $data);
        $data = preg_replace('/(__DIR__ ?\. ?)\'\/\.\.\/\'/', '$1\'/../../\'', $data);

        file_put_contents($path, $data);
    }

    protected function fixAppBootstrapAutoload()
    {
        $path = ($this->getPath() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'bootstrap' . DIRECTORY_SEPARATOR . 'autoload.php');

        if (!file_exists($path)) {
            return;
        }

        $data = file_get_contents($path);

        $data = preg_replace('/(__DIR__ ?\. ?)\'\/\.\.\/vendor\/autoload\.php\'/', '$1\'/../../vendor/autoload.php\'', $data);

        file_put_contents($path, $data);
    }

    protected function fixAppConfigView()
    {
        $path = ($this->getPath() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'view.php');

        if (!file_exists($path)) {
            return;
        }

        $data = file_get_contents($path);

        $data = preg_replace('/\'resources\/views\'/', '\'app/resources/views\'', $data);

        file_put_contents($path, $data);
    }

    protected function fixBinArtisan()
    {
        $path = ($this->getPath() . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'artisan');

        if (!file_exists($path)) {
            return;
        }

        $data = file_get_contents($path);

        $data = preg_replace('/(__DIR__ ?\. ?)\'\/bootstrap\//', '$1\'/../app/bootstrap/', $data);

        file_put_contents($path, $data);
    }

    protected function fixSrcConsoleKernel()
    {
        $path = ($this->getPath() . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Console' . DIRECTORY_SEPARATOR . 'Kernel.php');

        if (!file_exists($path)) {
            return;
        }

        $data = file_get_contents($path);

        $data = preg_replace('/\'routes\/console\.php\'/', '\'app/routes/console.php\'', $data);

        file_put_contents($path, $data);
    }

    protected function fixSrcProvidersBroadcastServiceProvider()
    {
        $path = ($this->getPath() . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Providers' . DIRECTORY_SEPARATOR . 'BroadcastServiceProvider.php');

        if (!file_exists($path)) {
            return;
        }

        $data = file_get_contents($path);

        $data = preg_replace('/\'routes\/channels\.php\'/', '\'app/routes/channels.php\'', $data);

        file_put_contents($path, $data);
    }

    protected function fixSrcProvidersRouteServiceProvider()
    {
        $path = ($this->getPath() . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Providers' . DIRECTORY_SEPARATOR . 'RouteServiceProvider.php');

        if (!file_exists($path)) {
            return;
        }

        $data = file_get_contents($path);

        $data = preg_replace('/\'routes\/web\.php\'/', '\'app/routes/web.php\'', $data);
        $data = preg_replace('/\'routes\/api\.php\'/', '\'app/routes/api.php\'', $data);

        file_put_contents($path, $data);
    }

    protected function fixComposerJson()
    {
        $composerJsonFile = ($this->getPath() . DIRECTORY_SEPARATOR . 'composer.json');
        $composerData = json_decode(file_get_contents($composerJsonFile), true);

        $composerData = str_replace('\/', '\\', $composerData);

        foreach ($composerData['autoload']['classmap'] as &$directory) {
            if ($directory === 'database') {
                $directory = 'app/database';
                break;
            }
        }

        foreach ($composerData['autoload']['psr-4'] as $namespace => &$directory) {
            if ($directory === 'app/') {
                $directory = 'src/';
                break;
            }
        }

        file_put_contents($composerJsonFile, json_encode($composerData, JSON_PRETTY_PRINT));
    }
}
