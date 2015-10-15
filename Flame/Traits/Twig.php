<?php

namespace Flame\Traits;

use Flame\Abstracts\BaseController;

trait Twig
{
    /** @var BaseController $controller */
    private $controller;

    public function extendsTwig(&$twig, BaseController $controller)
    {
        $twig->addFunction(new \Twig_SimpleFunction('printFile', [$this, 'printFile']));
        $twig->addFunction(new \Twig_SimpleFunction('route', [$this, 'route']));
        $twig->addFunction(new \Twig_SimpleFunction('repository', [$this, 'repository']));
        $twig->addFunction(new \Twig_SimpleFunction('resurl', [$this, 'resurl']));
        $twig->addFunction(new \Twig_SimpleFunction('module', [$this, 'printModule']));
        $twig->addFunction(new \Twig_SimpleFunction('dump', 'var_dump'));

        $this->controller = $controller;
    }

    public function printModule($name)
    {
        if (!$name) {
            return;
        }

        echo $this->controller->getDBus()->getReponse($name);
        $this->controller->getDBus()->removeReponse($name);
    }

    public function resurl($url, $type = 'img'){
        return $url;
    }

    public function repository($name, $type = '')
    {
        return $name;
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

        if ($fr = @fopen($filename, 'r')) {
            if (@fpassthru($fr)) {
                fclose($fr);
            };
        } else {
            // echo 'File not found: ' . $filename;
        }
    }
}
