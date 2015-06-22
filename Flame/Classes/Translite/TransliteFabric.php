<?php

namespace Flame\Classes\Translite;

class TransliteFabric
{
    const DEFAULT_ENCODING = 'DeafaultEncoding';

    public function get($encoding)
    {
        if (!$encoding) {
            throw new \Exception('Encoding not set');
        }

        $className = '\Flame\Classes\Translite\Locale\\' . $encoding;
        if (!class_exists($className)) {
            throw new \Exception('Encoding and Locate not found: ' . $className);
        }

        return new $className();
    }
}