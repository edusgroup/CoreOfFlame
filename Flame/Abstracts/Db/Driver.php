<?php

namespace Flame\Abstracts\Db;

abstract class Driver
{
    protected $dbName;

    protected $fields = [];
    protected $query = [];
    protected $tableName;
    protected $limit;

    /**
     * Указываем таблицу, в которой будем искать
     *
     * @param string $tableName Название таблицы
     *
     * @return Driver
     */
    public abstract function table($tableName);

    /**
     * @param array $field
     * @param array $where
     * @param array $order
     *
     * @return array Выбранные данные
     */
    public abstract function selectAll($field, $where, $order = []);

    /**
     * @return array
     */
    public abstract function db($name);

    /**
     * @param integer $count Количество элементов
     * @return Driver
     */
    public abstract function limit($count);

    /**
     * @return Driver
     */
    public abstract function select($fields);

    /**
     * @param $query
     *
     * @return $this
     */
    public abstract function where($query);

    /**
     * @return array
     */
    public abstract function selectFirst($fields, $where);

    public abstract function update($set, $where);

    public abstract function insert($fields);
    public abstract function save($fields);

    /**
     * @return array
     */
    public abstract function queryFirst();

    /**
     * @return array
     */
    public abstract function queryAll();

    public abstract function findAndModify($fields, $update, $where, $options = []);
}
