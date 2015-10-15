<?php

namespace Flame\Classes\Di;

use Symfony\Component\Yaml\Yaml;

class Di
{
    private $data;
    private $objList;
    private $siteRoot = '';
    private $httpHost = '';
    private $lang = '';

    public function initDi($storage, $format, $siteRoot, $diFile, $httpHost, $lang)
    {
        //$this->data = json_decode(file_get_contents($name));
        $this->data = Yaml::parse(file_get_contents($siteRoot . $diFile));
        $this->siteRoot = $siteRoot;
        $this->httpHost = $httpHost;
        $this->lang = $lang;
    }

    private function initClass($name)
    {
        if (!property_exists($this->data['class'], $name)) {
            throw new Exception\DiException('class ' . $name . ' not found');
        }
    }

    private function parseRes($name)
    {
        if (!isset($this->data['res'], $name)) {
            throw new Exception\DiException('Res ' . $name . ' not found in DI');
        }

        $obj = &$this->data['res'][$name];

        if (is_array($obj)) {
            $array = [];
            foreach ($obj as $val) {
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
            if ($val == '@controller') {
                return $this;
            }

            if ($val[0] == '@') {
                return $this->fabric(substr($val, 1));
            }

            if ($val[0] == '$') {
                return $this->parseRes(substr($val, 1));
            }
        } elseif (is_array($val)) {
            $param = [];
            foreach ($val as $item) {
                $param[] = $this->parse($item);
            }

            return $param;
        }

        return $val;
    }

    /**
     * Получае с помощью DI объект
     *
     * @param string $name Название объекта из di.yaml
     * @return mixed Запрашиваемый объект
     * @throws Exception\DiException В случае ошибки
     */
    public function fabric($name)
    {
        if ($name == 'siteRoot') {
            return $this->siteRoot;
        } elseif ($name == 'httpHost') {
            return $this->httpHost;
        } elseif ($name == 'lang') {
            return $this->lang;
        }

        // Если объект найден, то возвращаем его
        if (isset($this->objList[$name])) {
            return $this->objList[$name];
        }

        // Если имя не найдено
        if (!isset($this->data['class'][$name])) {
            throw new Exception\DiException('Name ' . $name . ' not found in DI');
        }

        // Если это не массив, то это неправильный формат
        if (!is_array($this->data['class'][$name])) {
            throw new Exception\DiException('Name [' . $name . '] is not array DI');
        }

        // Если класс не задан
        if (!isset($this->data['class'][$name]['class'])) {
            throw new Exception\DiException('Name [' . $name . '] don\'t have class name');
        }

        // получаем класс
        $className = $this->data['class'][$name]['class'];

        // Парсим параметры для создания
        $param = '';
        if (isset($this->data['class'][$name]['param'])) {
            $param = $this->parse($this->data['class'][$name]['param']);
        }

        // Если это не массив, то нужно создать массив
        if (!is_array($param)) {
            $param = [$param];
        }

        // Создаём класс
        $ref = new \ReflectionClass($className);
        $this->objList[$name] = $ref->newInstanceArgs($param);
        return $this->objList[$name];
    }
}
