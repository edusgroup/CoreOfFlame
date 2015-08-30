<?php

namespace Flame\Classes\OAuth\OAuthBase\Vk;


use Flame\Classes\OAuth\OAuthBase\OAuthBase;

class OAuthVk extends OAuthBase
{
    const USER_DB_OAUTH_KEY = 'vk';

    protected function getToketCodeResponse($data)
    {
        $result = new TokenCodeResponse();
        $result->expiresIn = $data->expires_in;
        $result->accessToken = $data->access_token;
        $result->userId = $data->user_id;
        $result->email = $data->email;

        return $result;
    }
}
