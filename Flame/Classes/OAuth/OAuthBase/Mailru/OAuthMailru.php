<?php

namespace Flame\Classes\OAuth\OAuthBase\Mailru;

use Flame\Classes\OAuth\OAuthBase\OAuthBase;

class OAuthMailru extends OAuthBase
{
    const USER_DB_OAUTH_KEY = 'mailru';

    protected function getToketCodeResponse($data)
    {
        $result = new TokenCodeResponse();
        $result->expiresIn = $data->expires_in;
        $result->refreshToken = $data->refresh_token;
        $result->accessToken = $data->access_token;
        // Не возращается при getRefreshTokenCode
        // $result->tokenType = $data->token_type;
        $result->userId = $data->x_mailru_vid;

        return $result;
    }
}
