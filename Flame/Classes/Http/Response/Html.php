<?php

namespace Flame\Classes\Http\Response;

use Flame\Abstracts\BaseController;

class Html extends \Flame\Abstracts\Http\Response
{
	protected $tplName;
	protected $varbileList;

    /** @var BaseController Контроллер */
    protected $controller;

	public function __construct($tplName, $varbileList, $controller)
	{
		$this->tplName = $tplName;
		$this->varbileList = $varbileList;
		$this->controller = $controller;
	}
	
	public function get()
	{
        $loader = new \Twig_Loader_Filesystem($this->controller->getTplDir());
        $twig = new \Twig_Environment($loader);
        $this->controller->preRenderCommon($twig, $this->tplName, $this->varbileList);

        $template = $twig->loadTemplate($this->tplName);
        return $template->render($this->varbileList);
	}
}
