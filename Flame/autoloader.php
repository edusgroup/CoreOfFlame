<?php

spl_autoload_register(function ($className) {
	$classNamePath = str_replace('\\', '/', $className);
    if ( substr($classNamePath, 0, 5) == 'Flame'){
        $classFileName = $_SERVER['CORE_ROOT'] . 'core/'. $classNamePath . '.php';
    }else{
        $classFileName = $_SERVER['SITE_ROOT'] . 'core/' . substr($classNamePath, 5) . '.php';
    }

    return @include($classFileName);
});
