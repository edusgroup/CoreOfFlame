<?php

namespace Flame\Abstracts\Model;

use Flame\Abstracts\Model\Read;

abstract class Collection implements \Iterator
{
    /** @var array Массив значений модели */
    protected $list = [];
    protected $isValid;

    /** @var Read Модель объекта */
    protected $model;

    public function __construct(array $list, Read $model)
    {
        $this->list = $list;
        $this->isValid = (boolean) $list;
        $this->model = $model;
    }

    public function rewind() {
        reset($this->list);
    }

    public function current() {
        $this->model->setList(current($this->list));
        return $this->model;
    }

    public function key() {
        return key($this->list);
    }

    public function next() {
        $this->isValid = (boolean) next($this->list);
    }

    public function valid() {
        return $this->isValid;
    }
}
