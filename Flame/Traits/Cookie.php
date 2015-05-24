<?php

namespace Flame\Traits;

trait Cookie
{
    public function setCookie($name, $value, $lifeTime, $path = '/', $isHttp = false, $httpHost = null)
    {
        $httpHost = $httpHost ?: $_SERVER['HTTP_HOST'];
        setCookie($name, $value, $_SERVER['REQUEST_TIME'] + $lifeTime, $path, $httpHost, $isHttp);
    }

    public function removeCookie($name)
    {
        setCookie($name, '', $_SERVER['REQUEST_TIME'] - 3600);
    }

    public function getCookie($name)
    {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    }
}
