<?php

namespace Flame\Abstracts;

use Flame\Classes\Http\Exception\Error4xx;

abstract class BaseController extends \Flame\Classes\Di\Di
{
    private $baseDir;

    protected $initObj;

    const JSON_SUCCESS = true;
    const JSON_ERROR = false;

    const REQUEST_TYPE_AJAX = true;
    const REQUEST_TYPE_NONE_AJAX = false;

    /** @var boolean ajax ли запроса */
    private $requestType;

    public function __construct($routeName, $initObj)
    {
        $this->initObj = $initObj;
    }

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

    public function getRoutePath($name)
    {
        if (!isset($this->initObj->getRouteData()[$name])) {
            return '';
        }

        $item = $this->initObj->getRouteData()[$name];

        $limit = func_num_args() - 1;
        $url = preg_replace('/{[^}]+}/', '%s', $item['regexp'], $limit);

        $args = func_get_args();
        unset($args[0]);
        $url = vsprintf($url, $args);
        $url = trim($url, '$^');

        return $url;
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
        return $this->baseDir . 'conf/';
    }

    public function getDataDir()
    {
        return $this->baseDir . 'data/';
    }

    public function getFileFormData($filename)
    {
        return $this->getDataDir() . $filename;
    }

    public function getTplDir()
    {
        return $this->baseDir . 'tpl/';
    }

    public function invokeError4xx($msg = '', $code = 404)
    {
        throw new Error4xx('Error ' . $code . ' Msg: ' . $msg, $code);
    }

    public function ifNullInvokeError4xx($data, $msg = '', $code = 404)
    {
        if (!$data) {
            $this->invokeError4xx($msg, $code);
        }
    }

    public abstract function preInitCommon($methodName, $matches);

    public abstract function preRenderCommon(\Twig_Environment $twig, &$tplName, &$varible);

    protected abstract function preCallAction($methodName);

}