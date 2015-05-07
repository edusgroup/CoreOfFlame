<?php

namespace Flame\Classes\Di;

use Symfony\Component\Yaml\Yaml;

class Di
{
    private $data;
    private $objList;

    public function initDi($storage, $format, $name)
    {
        //$this->data = json_decode(file_get_contents($name));
        $this->data = Yaml::parse($name);
    }

    private function initClass($name)
    {
        if (!property_exists($this->data['class'], $name)) {
            throw new Exception\DiException('class '.$name.' not found');
        }
    }

    private function parseRes($name)
    {
        if (!isset($this->data['res'], $name)) {
            throw new Exception\DiException('Res '.$name.' not found in DI');
        }

        $obj = &$this->data['res'][$name];

        if (is_array($obj)) {
            $array = [];
            foreach($obj as $val) {
                $array[] = $val;
            }
            return $array;
        }

        return $obj;
    }

    private function parse($val)
    {
        if (!$val) {
            return $val;
        }

        if (is_string($val)) {
            if ($val[0] == '@') {
                return $this->fabric(substr($val, 1));
            }

            if ($val[0] == '$') {
                return $this->parseRes(substr($val, 1));
            }
        }elseif (is_array($val)) {
            $param = [];
            foreach($val as $item) {
                $param[] = $this->parse($item);
            }

            return $param;
        }

        return $val;
    }

	public function fabric($name)
	{
        if (isset($this->objList[$name])) {
            return $this->objList[$name];
        }

        if (!isset($this->data['class'], $name)) {
            throw new Exception\DiException('Name '.$name.' not found in DI');
        }

        if (!is_array($this->data['class'][$name])) {
            throw new Exception\DiException('Name ['.$name.'] is not array DI');
        }

        if (!isset($this->data['class'][$name]['class'])) {
            throw new Exception\DiException('Name ['.$name.'] don\'t have class name');
        }

        $className = $this->data['class'][$name]['class'];

        $param = '';
        if (isset($this->data['class'][$name]['param'])) {
            $param = $this->parse($this->data['class'][$name]['param']);
        }

        if (!is_array($param)) {
            $param = [$param];
        }

        $ref = new \ReflectionClass($className);
        return $this->objList[$name] = $ref->newInstanceArgs($param);
	}
}
