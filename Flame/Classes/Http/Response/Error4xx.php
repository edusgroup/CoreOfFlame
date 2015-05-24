<?php

namespace Flame\Classes\Http\Response;

use Flame\Abstracts\Http\Response;

class Error4xx extends Response
{
    protected $code;

    public function __construct($code)
    {
        $this->code = (int)$code;
    }

    public function get()
    {
        return $this->code;
    }
}
