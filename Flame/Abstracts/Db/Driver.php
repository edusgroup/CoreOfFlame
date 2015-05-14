<?php

namespace Flame\Abstracts\Db;

abstract class Driver
{
    protected $dbName;

    protected $fields = [];
    protected $query = [];
    protected $tableName;

    /**
     * Указываем таблицу, в которой будем искать
     *
     * @param $tableName Название таблицы
     * @return $this
     */
    public abstract function table($tableName);

    /**
     * @param $field
     * @param $where
     * @param array $order
     * @return array Выбранные данные
     */
    public abstract function selectAll($field, $where, $order = []);

    /**
     * @return array
     */
    public abstract function db($name);
    /**
     * @return array
     */
    public abstract function select($fields);

    /**
     * @param $query
     * @return $this
     */
    public abstract function where($query);
    /**
     * @return array
     */
    public abstract function selectFirst($fields, $where);

    public abstract function update($set, $where);

    public abstract function insert($fields);

    /**
     * @return array
     */
    public abstract function queryFirst();

    /**
     * @return array
     */
    public abstract function queryAll();
}
