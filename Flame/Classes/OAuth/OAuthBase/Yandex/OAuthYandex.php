<?php

namespace Flame\Classes\OAuth\OAuthBase\Yandex;


use Flame\Classes\OAuth\OAuthBase\OAuthBase;

class OAuthYandex extends OAuthBase
{
    const USER_DB_OAUTH_KEY = 'yandex';

    protected function getToketCodeResponse($data)
    {
        $result = new TokenCodeResponse();
        $result->expiresIn = $data->expires_in;
        $result->accessToken = $data->access_token;

        return $result;
    }
}
