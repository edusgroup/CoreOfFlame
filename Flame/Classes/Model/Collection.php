<?php

namespace Flame\Classes\Model;

use Flame\Abstracts\Model\Read;

class Collection implements \Iterator
{
    protected $isValid;

    /** @var Read Модель объекта */
    protected $model;

    public function __construct(array $list, Read $model)
    {
        $this->list = $list;
        $this->model = $model;
    }

    public function rewind()
    {
        reset($this->list);
    }

    public function current()
    {
        $this->model->setElementsList(current($this->list));
        return $this->model;
    }

    public function key()
    {
        return key($this->list);
    }

    public function next()
    {
        next($this->list);
        return $this->current();
    }

    public function valid()
    {
        return false !== current($this->list);
    }

    public function length()
    {
        return count($this->list);
    }
}
