<?php

namespace Flame\Classes\Db\Driver;

use Flame\Abstracts\Db\Driver;

class Mongo extends Driver
{
    protected $mongoHandle;

    /**
     * @param $db
     * @param $dbName Название БД
     */
    public function __construct($db, $dbName)
    {
        $this->mongoHandle = $db;
        $this->dbName = $dbName;
    }

    public function update($updateFields, $where)
    {

        return $this->mongoHandle->selectDB($this->dbName)->{$this->tableName}->update(
            $where,
            $updateFields,
            ['upsert' => true]
        );
    }

    public function insert($fields)
    {
        $this->mongoHandle->selectDB($this->dbName)->{$this->tableName}->insert($fields);
    }

    public function table($tableName)
    {
        $this->tableName = $tableName;

        return $this;
    }

    public function selectAll($fields, $where, $order = [])
    {
        return $this->select($fields)->where($where)->queryAll();
    }

    public function db($name)
    {
        $this->dbName = $name;

        return $this;
    }

    public function select($fields)
    {
        $this->fields = $fields;

        return $this;
    }

    public function where($query)
    {
        $this->query = $query;

        return $this;
    }

    public function selectFirst($fields, $where)
    {
        return $this->select($fields)->where($where)->queryFirst();
    }

    public function queryFirst()
    {
        return $this->mongoHandle->selectDB($this->dbName)->{$this->tableName}->findOne(
            $this->query,
            $this->fields
        );
    }

    public function queryAll()
    {
        return $this->mongoHandle->selectDB($this->dbName)->{$this->tableName}->find(
            $this->query,
            $this->fields
        );
    }
} 