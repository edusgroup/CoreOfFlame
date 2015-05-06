<?php

namespace Flame\Abstracts;

use Flame\Classes\Http\Exception\Error4xx;

abstract class BaseController extends \Flame\Classes\Di\Di
{
    private $baseDir;
	
	const JSON_SUCCESS = true;
	const JSON_ERROR = false;

    const REQUEST_TYPE_AJAX = true;
    const REQUEST_TYPE_NONE_AJAX = false;

    /** @var boolean ajax ли запроса */
    private $requestType;

    /**
     * Устанавливаем тип запроса. Ajax или нет
     *
     * @param $requestType Константа REQUEST_TYPE_AJAX или REQUEST_TYPE_NONE_AJAX
     */
	public function setRequestType($requestType)
    {
        $this->requestType = $requestType;
    }

    public function run($methodName, $matches)
    {
        $this->preCallAction($methodName);
        return call_user_func_array([$this, $methodName], $matches);
    }

    /**
     * Проверяем Ajax ли это запрос
     *
     * @return bool Ajax ли запроса
     */
    public function isAjax()
    {
        return $this->requestType;
    }

    public function setBaseDir($baseDir)
    {
        $this->baseDir = $baseDir;
    }

    public function getConfDir()
    {
        return $this->baseDir.'conf/';
    }

    public function getDataDir()
    {
        return $this->baseDir.'data/';
    }

    public function getFileFormData($filename)
    {
        return $this->getDataDir() . $filename;
    }

    public function getTplDir()
    {
        return $this->baseDir.'tpl/';
    }

	public function invokeError4xx($code = 404){
		throw new Error4xx('Error ' . $code, $code);
	}
	
	public abstract function preInitCommon($methodName, $matches);
	public abstract function preRenderCommon(\Twig_Environment $twig, &$tplName, &$varible);
	protected abstract function preCallAction($methodName);

}