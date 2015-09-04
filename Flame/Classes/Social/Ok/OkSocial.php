<?php

namespace Flame\Classes\Social\Ok;

use Flame\Classes\CurlExt;
use Flame\Classes\Utils\ArrayHelp;

/**
 * @author Kozlenko Vitaliy
 * @see http://coddism.com/php/oauth_avtorizacija_cherez_odnoklassnikiru
 */
class OkSocial
{
    /** @var CurlExt Расширенный curl */
    protected $curl;
    private $appId;
    private $privateKey;
    private $publicKey;

    public function __construct($appId, $privateKey, $publicKey)
    {
        $this->curl = new CurlExt();
        $this->appId = $appId;
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
    }

    public function getUserInfo($authToken)
    {
        $sign = md5($authToken . $this->privateKey);
        $sing = md5('application_key=' . $this->publicKey . 'method=users.getCurrentUser' . $sign);

        $params = [
            'access_token' => $authToken,
            'method' => 'users.getCurrentUser',
            'application_key' => $this->publicKey,
            'sig' => $sing
        ];

        $data = $this->curl->get('http://api.odnoklassniki.ru/fb.do?' . http_build_query($params));
        $data = @json_decode($data);
        if (!$data) {
            return null;
        }

        return new OkUser($data);
    }
}
