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
}
