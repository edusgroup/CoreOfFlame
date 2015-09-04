<?php

namespace Flame\Classes\OAuth\OAuthBase\Ok;


use Flame\Classes\OAuth\OAuthBase\OAuthBase;

class OAuthOk extends OAuthBase
{
    const USER_DB_OAUTH_KEY = 'ok';

    protected function getToketCodeResponse($data)
    {
        $result = new TokenCodeResponse();
        $result->expiresIn = $data->expires_in;
        $result->accessToken = $data->access_token;

        return $result;
    }
}
