<?php

spl_autoload_register(function ($className) {
    $classNamePath = str_replace('\\', '/', $className);
    if ( substr($classNamePath, 0, 5) == 'Flame'){
        $classFileName = CORE_ROOT . 'core/'. $classNamePath . '.php';
    }else{
        $classFileName = SITE_ROOT . 'core/' . substr($classNamePath, 5) . '.php';
    }

    // echo $classFileName, '<br/>', PHP_EOL;
    return include($classFileName);
});
