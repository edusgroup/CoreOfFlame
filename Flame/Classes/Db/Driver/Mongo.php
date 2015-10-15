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
        /** @var \MongoCollection $table */
        $table = $this->mongoHandle->selectDB($this->dbName)->{$this->tableName};
        return $table->update(
            $where,
            $updateFields,
            ['upsert' => true]
        );
    }

    /**
     * @param int $limit
     * @return Mongo
     */
    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function insert($fields)
    {
        /** @var \MongoCollection $table */
        $table = $this->mongoHandle->selectDB($this->dbName)->{$this->tableName};
        return $table->insert($fields);
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
        $this->query = [];
        $this->limit = 0;

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
        /** @var \MongoCollection $table */
        $table = $this->mongoHandle->selectDB($this->dbName)->{$this->tableName};
        return $table->findOne(
            $this->query,
            $this->fields
        );
    }

    public function findAndModify($fields, $update, $where, $options = [])
    {
        /** @var \MongoCollection $table */
        $table = $this->mongoHandle->selectDB($this->dbName)->{$this->tableName};
        return $table->findAndModify(
            $where,
            $update,
            $fields,
            $options
        );
    }

    public function save($fields)
    {
        /** @var \MongoCollection $table */
        $table = $this->mongoHandle->selectDB($this->dbName)->{$this->tableName};
        return $table->findOne($fields);
    }


    public function queryAll()
    {
        /** @var \MongoCollection $table */
        $table = $this->mongoHandle->selectDB($this->dbName)->{$this->tableName};
        $query = $table->find(
            $this->query,
            $this->fields
        );

        if ($this->limit) {
            $query->limit($this->limit);
        }

        return $query;
    }
} 