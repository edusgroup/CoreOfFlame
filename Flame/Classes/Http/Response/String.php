<?php

namespace Flame\Classes\Http\Response;

use Flame\Abstracts\Http\Response;

class String extends Response
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function get()
    {
        return $this->data;
    }
}
