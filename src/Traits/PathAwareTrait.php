<?php

namespace Meowstic\Traits;

trait PathAwareTrait
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }
}
