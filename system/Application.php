<?php

namespace System;

class Application extends \Illuminate\Foundation\Application
{
    /**
     * @inheritdoc
     */
    public function path($path = '')
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 
                'system' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * @inheritdoc
     */
    public function databasePath($path = '')
    {
        return ($this->databasePath ?: 
                $this->path().DIRECTORY_SEPARATOR.'database')
                .($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}