<?php

namespace Flame\Classes\Utils;

class ArrayHelp
{
    public function shuffleAssoc($list) {
        if (!is_array($list)) return $list;

        $keys = array_keys($list);
        shuffle($keys);
        $random = array();
        foreach ($keys as $key) {
            $random[$key] = $list[$key];
        }
        return $random;
    }

    public function arrayKeyValueJoin($array, $delimiter = '')
    {
        return implode($delimiter, array_map(function ($value, $key) {
            return $key . '=' . $value;
        }, $array, array_keys($array)));
    }
}
