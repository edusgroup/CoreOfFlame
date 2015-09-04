<?php

namespace Flame\Classes\OAuth\OAuthBase\Ok;


class TokenCodeResponse
{
    /** @var integer Через сколько истекёт access_token */
    public $expiresIn;
    public $accessToken;
}