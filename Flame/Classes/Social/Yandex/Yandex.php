<?php

namespace Flame\Classes\Social\Yandex;

use Flame\Classes\CurlExt;

class Yandex
{
    /** @var CurlExt Расширенный curl */
    protected $curl;

    public function __construct()
    {
        $this->curl = new CurlExt();
    }

    public function getUserInfo($authToken)
    {
        $data = $this->curl->get('https://login.yandex.ru/info?format=json&oauth_token='.$authToken);
        $data = @json_decode($data);
        if (!$data) {
            return null;
        }

        return new YaUser($data);
    }
}
