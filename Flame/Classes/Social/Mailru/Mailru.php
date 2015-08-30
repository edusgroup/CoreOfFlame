<?php

namespace Flame\Classes\Social\Mailru;

use Flame\Classes\CurlExt;
use Flame\Classes\OAuth\OAuthBase\Mailru\ToketCodeResponse;
use Flame\Classes\Utils\ArrayHelp;

/**
 * @author Козленко В.Л.
 * @see http://api.mail.ru/docs/guides/oauth/sites/
 * @see http://habrahabr.ru/company/mailru/blog/115163/
 */
class Mailru
{
    const URL_API = 'http://www.appsmail.ru/platform/api';

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
     * @param ToketCodeResponse $accessToken
     *
     * @return UserInfo<> Массив моделей пользователей
     */
    public function getUserInfo($accessToken)
    {
        // Ключи должны быть в алфавитном порядке, это крайне важно!
        $params = [
            'app_id' => $this->siteId,
            'method' => 'users.getInfo',
            'secure' => '1',
            'session_key' => $accessToken->accessToken
        ];

        $params['sig'] = $this->createSign($params);
        $data = $this->curl->post(self::URL_API, $params);
        $data = @json_decode($data);
        if (isset($data->error)) {
            return null;
        }

        $data = array_map(function ($item) {
            return new UserInfo($item);
        }, $data);

        return $data;
    }

    /**
     * @param Array $data Массив данных для процедуры. Ключи должны быть в алфавитном порядке, это крайне важно!
     *
     * @return string Подпись для запроса
     */
    protected function createSign($params)
    {
        $sign = (new ArrayHelp())->arrayKeyValueJoin($params);
        return md5($sign . $this->clientSecret);
    }
}
