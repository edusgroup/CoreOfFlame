<?php

namespace Flame\Classes;

/**
 * Работа с хлебными крошками
 * @author Козленко В.Л.
 */
class BreadCrumbs implements \Iterator
{
    private $position = 0;
    private $array = [];
    private $name = '';

    public function __construct(array $list, $name) {
        $this->position = 0;
        $this->array = $list;
        $this->name = $name;
    }

    function getName()
    {
        return $this->name;
    }

    function add($url, $name)
    {
        $this->array[] = ['url' => $url, 'name' => $name];
    }

    function rewind() {
        $this->position = 0;
    }

    function current() {
        return $this->array[$this->position];
    }

    function key() {
        return $this->position;
    }

    function next() {
        ++$this->position;
    }

    function valid() {
        return isset($this->array[$this->position]);
    }
}
