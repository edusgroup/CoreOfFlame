<?php

namespace Flame\Classes\Social\Vk;

use Flame\Classes\CurlExt;
use Flame\Classes\Utils\ArrayHelp;

class Vk
{
    const URL_API = 'https://api.vk.com/method/';

    /** @var CurlExt Расширенный curl */
    protected $curl;
    protected $siteId;
    protected $clientSecret;

    public function __construct($siteId, $clientSecret)
    {
        $this->curl = new CurlExt();
        $this->siteId = $siteId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * @param $vkUserId
     * @param $accessToken
     * @return VkUser<>|null
     */
    public function getUserInfo($vkUserId, $accessToken)
    {
        $params = [
            'user_id' => $vkUserId,
            'vk' => '5.37',
            'access_token' => $accessToken
        ];

        $url = self::URL_API . 'users.get';
        $data = $this->curl->get($url, $params);
        $data = json_decode($data);

        if (!$data->response) {
            return null;
        }

        return array_map(function($item){
            return new VkUser($item);
        }, $data->response);
    }
}