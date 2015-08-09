<?php

namespace Flame\Abstracts\StreamReader;

abstract class StreamReader
{
    protected $uri = '';

    public function __construct($uri)
    {
        if (!$uri) {
            throw new \Exception('URI not set');
        }

        $this->uri = $uri;
    }

    public abstract function getData();
}