<?php

namespace Flame\Abstracts;

use Flame\Classes\DBus\DBus;
use Flame\Classes\Http\Exception\Error4xx;
use Flame\Classes\Http\Response\Redirect;

abstract class BaseController extends \Flame\Classes\Di\Di
{
    private $baseDir;

    protected $initObj;

    const JSON_SUCCESS = true;
    const JSON_ERROR = false;

    const REQUEST_TYPE_AJAX = true;
    const REQUEST_TYPE_NONE_AJAX = false;

    const REDIRECT_TEMPORARY = 302;
    const REDIRECT_PERMANENT = 301;

    const HTTP_ERROR_CODE = 404;

    /** @var boolean ajax ли запроса */
    private $requestType;

    protected $dbus;

    public function __construct($routeName, $initObj)
    {
        $this->initObj = $initObj;
        $this->dbus = new DBus();
    }

    public function getDBus()
    {
        return $this->dbus;
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

    /**
     * Строим URL из route.yaml
     *
     * @param string $name Название записи из route.yaml
     * @param string ..., optional Переменные для URL
     * @return string URL если запись найдена в route.yaml иначе пустая строка
     */
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

    public function getPublicDir()
    {
        return $this->baseDir . 'public/';
    }

    public function getTplDir()
    {
        return $this->baseDir . 'tpl/';
    }

    public function invokeError4xx($msg = '', $code = self::HTTP_ERROR_CODE)
    {
        throw new Error4xx('Error ' . $code . ' Msg: ' . $msg, $code);
    }

    /**
     * Редирект на другой URL
     *
     * @param string $url URL для редиректа
     * @param int $code Код редиректа. @see self::REDIRECT_*
     */
    public function redirectToUrl($url, $code = self::REDIRECT_PERMANENT)
    {
        header('Location: ' . $url, true, $code);
        return new Redirect();
    }

    public function ifNullInvokeError4xx($data, $msg = '', $code = self::HTTP_ERROR_CODE)
    {
        if (!$data) {
            $this->invokeError4xx($msg, $code);
        }
    }

    public abstract function preInitCommon($methodName, $matches);

    public abstract function preRenderCommon(\Twig_Environment $twig, &$tplName, &$varible);

    protected abstract function preCallAction($methodName);

}