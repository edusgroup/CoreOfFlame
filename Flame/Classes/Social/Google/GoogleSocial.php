<?php

namespace Flame\Classes\Social\Google;

use Flame\Classes\CurlExt;
use Flame\Classes\Utils\ArrayHelp;

/**
 * @author Kozlenko Vitaliy
 */
class GoogleSocial
{
    /** @var CurlExt Расширенный curl */
    protected $curl;

    public function __construct()
    {
        $this->curl = new CurlExt();
    }

    public function getUserInfo($accessToken)
    {
        $data = $this->curl->get('https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $accessToken);
        $data = @json_decode($data);
        if (!$data) {
            return null;
        }

        return new GoogleUser($data);
    }
}
