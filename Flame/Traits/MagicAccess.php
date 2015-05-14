<?php
namespace Flame\Traits;

use Flame\Classes\Func\Exception\PropertyNotFoundException;

trait MagicAccess {
    public function __call($name, array $arguments)
    {
        $name = substr(strtolower($name), 3);
        $name = '_' . $name . '_';
        if (!property_exists($this, $name)) {
            throw new \Flame\Classes\Func\Exception\PropertyNotFoundException();
        }

        if (!$arguments) {
            return $this->{$name};
        }else{
            $this->{$name} = $arguments[0];
        }
    }
} 