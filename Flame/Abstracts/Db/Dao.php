<?php

namespace Flame\Abstracts\Db;


abstract class Dao
{
    public $driver;

    /**
     * @param \Flame\Abstracts\Db\Driver $driver
     */
    public function __construct($driver)
    {
        $this->driver = $driver;
    }

    public function mapping($array, $map)
    {
        $result = [];
        foreach($array as $mainKey => $mainValue) {
            foreach($mainValue as $key => $value) {
                if (isset($map[$key])) {
                    list($name, $type) = is_array($map[$key]) ? [$map[$key]['name'], $map[$key]['type']] : [$map[$key], 'string'];
                    $result[$mainKey][$name] = $value;
                }
            }
            if (isset($map['#key'])) {
                $name = $map['#key'];
                $result[$mainKey][$name] = $mainKey;
            }
        }

        return $result;
    }
}
