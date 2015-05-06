<?php

namespace Flame\Abstracts\Db;

abstract class Driver
{
    protected $dbName;

    protected $fields = [];
    protected $query = [];
    protected $tableName;

    public abstract function table($tableName);
    public abstract function selectAll($field, $where, $order = []);
    public abstract function db($name);
    public abstract function select($fields);
    public abstract function where($query);
    public abstract function selectFirst($fields, $where);
    public abstract function queryFirst();
    public abstract function queryAll();
}
