<?php

namespace Flame\Classes\Social\Facebook;

use Flame\Classes\CurlExt;
use Flame\Classes\Utils\ArrayHelp;

/**
 * @author Kozlenko Vitaliy
 */
class FbSocial
{
    /** @var CurlExt Расширенный curl */
    protected $curl;
    private $appId;
    private $privateKey;

    public function __construct($appId, $privateKey)
    {
        $this->curl = new CurlExt();
        $this->appId = $appId;
        $this->privateKey = $privateKey;
    }

    public function getUserInfo($authToken)
    {
        $data = $this->curl->get('https://graph.facebook.com/me?fields=email,first_name&access_token=' . $authToken);
        $data = @json_decode($data);
        if (!$data) {
            return null;
        }

        return new FbUser($data);
    }
}
