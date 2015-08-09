<?php

namespace Flame\Classes\StreamReader;


use Flame\Abstracts\StreamReader\StreamReader;

class FabricStreamReader
{
    /**
     * @param $uri
     * @return StreamReader
     * @throws \Exception
     */
    public function get($uri) {
        if (!$uri) {
            throw new \Exception('Uri not set');
        }

        // local
        if ($uri[0] == '/' || substr($uri, 1, 2) == ':\\' || substr($uri, 1, 2) == ':/') {
            return new FileStream($uri);
        }

        // http
        if (substr($uri, 0, 4) == 'http') {
            throw new \Exception('not support yet');
        }

        // memcache
        if (substr($uri, 0, 2) == 'mc') {
            throw new \Exception('not support yet');
        }

        throw new \Exception('Wrong uri');
    }
}