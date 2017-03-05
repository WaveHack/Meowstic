<?php

namespace Meowstic\Traits;

use Exception;

trait NamespaceAwareTrait
{
    use PathAwareTrait;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @return string
     * @throws Exception
     */
    public function getNamespace()
    {
        if ($this->namespace) {
            return $this->namespace;
        }

        $composerJsonFile = ($this->getPath() . DIRECTORY_SEPARATOR . 'composer.json');
        $composerData = json_decode(file_get_contents($composerJsonFile), true);

        $namespace = null;

        foreach ($composerData['autoload']['psr-4'] as $namespace => $directory) {
            if ($directory === 'app/') {
                $namespace = rtrim($namespace, '\\');
                break;
            }
        }

        if ($namespace === null) {
            throw new Exception('Namespace not found');
        }

        $this->namespace = $namespace;
        return $namespace;
    }
}
