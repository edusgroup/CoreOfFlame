<?php

namespace Flame\Classes\DBus;

use Flame\Classes\DBus\Exception\DBusException;

class DBus
{
    private $dbus = [];
    private $moduleResponse = [];

    const COMMON_DATA = 'default';

    public function setData($name, ExportData $params)
    {
        if (!$name) {
            throw new DBusException('Name is null');
        }

        $this->dbus[$name] = $params;
    }

    public function getData($name)
    {
        $name = $name ?: self::COMMON_DATA;
        return isset($this->dbus[$name]) ? $this->dbus[$name] : null;
    }

    public function setReponse($name, $data)
    {
        if (!$name) {
            throw new DBusException('Name is null');
        }

        $this->moduleResponse[$name] = $data;
    }

    public function getReponse($name)
    {
        return isset($this->moduleResponse[$name]) ? $this->moduleResponse[$name] : 'Answer for ' . $name . ' not found';
    }

    public function removeReponse($name)
    {
        if (isset($this->moduleResponse[$name])) {
            unset($this->moduleResponse[$name]);
        }
    }
}
