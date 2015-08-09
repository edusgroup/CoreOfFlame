<?php

namespace Flame\Classes\StreamReader;

use Flame\Abstracts\StreamReader\StreamReader;

class FileStream extends StreamReader
{
    public function getData()
    {
        return @file_get_contents($this->uri);
    }
}