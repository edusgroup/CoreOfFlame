<?php

namespace Flame\Classes\Translite\Locale;

use Flame\Abstracts\Translite;

class DeafaultEncoding extends Translite
{
    public function getEncoding()
    {
        return 'default';
    }

    public function convert($text)
    {
        return $text;
    }
}
