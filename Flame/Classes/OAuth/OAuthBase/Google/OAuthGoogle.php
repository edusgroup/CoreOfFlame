<?php

namespace Flame\Classes\OAuth\OAuthBase\Google;


use Flame\Classes\OAuth\OAuthBase\OAuthBase;

class OAuthGoogle extends OAuthBase
{
    const USER_DB_OAUTH_KEY = 'google';

    protected function getToketCodeResponse($data)
    {
        $result = new TokenCodeResponse();
        $result->expiresIn = $data->expires_in;
        $result->accessToken = $data->access_token;
        $result->idToken = $data->id_token;

        return $result;
    }
}
