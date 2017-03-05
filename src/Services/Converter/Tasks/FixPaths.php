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
        $this->fixBinArtisan();
        $this->fixPublicIndex();
        $this->fixSrcConsoleKernel();
        $this->fixSrcProvidersBroadcastServiceProvider();
        $this->fixSrcProvidersRouteServiceProvider();
        $this->fixGitIgnore();
        $this->fixComposerJson();
    }

    protected function fixAppBootstrapApp()
    {
        return $this->fixFile('app/bootstrap/app.php', function ($data) {
            $applicationFCQN = ($this->getNamespace() . '\\Application');

            $data = str_replace('new Illuminate\\Foundation\\Application', ('new ' . $applicationFCQN), $data);
            $data = preg_replace('/(__DIR__ ?\. ?[\'"])\/\.\.\/([\'"])/', '$1/../../$2', $data);

            return $data;
        });
    }

    protected function fixAppBootstrapAutoload()
    {
        return $this->fixFile('app/bootstrap/autoload.php', function ($data) {
            return preg_replace('/(__DIR__ ?\. ?[\'"])\/\.\.\/vendor\/autoload\.php/', '$1\/../../vendor/autoload.php', $data);
        });
    }

    protected function fixBinArtisan()
    {
        return $this->fixFile('bin/artisan', function ($data) {
            return preg_replace('/(__DIR__ ?\. ?[\'"])\/bootstrap\//', '$1\/../app/bootstrap/', $data);
        });
    }

    protected function fixPublicIndex()
    {
        return $this->fixFile('public/index.php', function ($data) {
            return str_replace('/../bootstrap/', '/../app/bootstrap/', $data);
        });
    }

    protected function fixSrcConsoleKernel()
    {
        return $this->fixFile('src/Console/Kernel.php', function ($data) {
            return str_replace('routes/console.php', 'app/routes/console.php', $data);
        });
    }

    protected function fixSrcProvidersBroadcastServiceProvider()
    {
        return $this->fixFile('src/Providers/RouteServiceProvider.php', function ($data) {
            return str_replace('routes/channels.php', 'app/routes/channels.php', $data);
        });
    }

    protected function fixSrcProvidersRouteServiceProvider()
    {
        return $this->fixFile('src/Providers/RouteServiceProvider.php', function ($data) {
            $data = str_replace('routes/api.php', 'app/routes/api.php', $data);
            $data = str_replace('routes/web.php', 'app/routes/web.php', $data);

            return $data;
        });
    }

    protected function fixGitIgnore()
    {
        return $this->fixFile('.gitignore', function ($data) {
            return str_replace('/storage/*.key', '/app/storage/*.key', $data);
        });
    }

    protected function fixComposerJson()
    {
        return $this->fixFile('composer.json', function ($data) {
            $json = json_decode($data, true);

            foreach ($json['autoload']['classmap'] as &$directory) {
                if ($directory === 'database') {
                    $directory = 'app/database';
                    break;
                }
            }

            foreach ($json['autoload']['psr-4'] as $namespace => &$directory) {
                if ($directory === 'app/') {
                    $directory = 'src/';
                    break;
                }
            }

            $data = json_encode($json, JSON_PRETTY_PRINT);

            $data = str_replace('\/', '/', $data);
            $data = str_replace('php artisan', 'php bin/artisan', $data);

            return $data;
        });
    }

    /**
     * @param string $path
     * @param callable $function
     * @return bool
     */
    protected function fixFile($path, callable $function)
    {
        $path = str_replace('/', DIRECTORY_SEPARATOR, $path);
        $path = ($this->getPath() . DIRECTORY_SEPARATOR . $path);

        if (!file_exists($path)) {
            return false;
        }

        $data = file_get_contents($path);
        $data = $function($data);
        file_put_contents($path, $data);

        return true;
    }
}
