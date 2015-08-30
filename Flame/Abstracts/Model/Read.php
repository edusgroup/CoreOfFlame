<?php

namespace Flame\Abstracts\Model;

abstract class Read
{
    /** @var array Массив значений модели */
    protected $list = [];

    public function __construct($list = [])
    {
        $this->setList($list);
    }

    public function getId()
    {
        return isset($this->list['_id']) ? (string) $this->list['_id'] : null;
    }

    public function setElementsList($list)
    {
        $this->list = $list;
    }

    public function getElementsList() {
        return $this->list;
    }

    public function __get($name)
    {

        return $this->get($name);
    }

    protected function get($name)
    {
        $name[0] = strtolower($name[0]);
        return isset($this->list[$name]) ? $this->list[$name] : null;
    }

    public function __call($methodName, $arguments)
    {   if (substr($methodName, 0, 3) == 'get') {
            return $this->get(substr($methodName, 3));
        }

        return $this->get($methodName);
    }
}
