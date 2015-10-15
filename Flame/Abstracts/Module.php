<?php

namespace Flame\Abstracts;

use Flame\Traits\Twig;

class Module
{
    use Twig;

    protected $dbus;
    protected $user;

    private $baseContoller;

    public function __construct(BaseController $controller)
    {
        $this->baseContoller = $controller;
        $this->dbus = $this->baseContoller->getDBus();
    }

    public function getController()
    {
        return $this->baseContoller;
    }

    public function export($data)
    {
        $this->dbus->setData($this->MODULE_NAME, $data);
    }

    public function import($name = null)
    {
        return $this->dbus->getData($name);
    }

    public function getResponse($tpl, $params)
    {
        $loader = new \Twig_Loader_Filesystem($this->baseContoller->getTplDir());
        $twig = new \Twig_Environment($loader);
        $this->extendsTwig($twig, $this->baseContoller);

        $template = $twig->loadTemplate($tpl);

        return $template->render($params);
    }
}
