<?php

namespace Flame\Traits;

trait Twig
{
    public function extendsTwig(&$twig)
    {
        $twig->addFunction(new \Twig_SimpleFunction('printFile', [$this, 'printFile']));
        $twig->addFunction(new \Twig_SimpleFunction('route', [$this, 'route']));
    }

    public function route($name)
    {
        return call_user_func_array([$this, 'getRoutePath'], func_get_args());
    }

    public function printFile($filename)
    {
        if (!$filename) {
            return;
        }

        if ($fr = fopen($filename, 'r')) {
            if (fpassthru($fr)) {
                fclose($fr);
            }
        }
    }
}
