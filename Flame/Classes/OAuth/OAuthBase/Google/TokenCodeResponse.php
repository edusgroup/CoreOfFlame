<?php

namespace Flame\Classes\OAuth\OAuthBase\Google;


class TokenCodeResponse
{
    /** @var integer Через сколько истекёт access_token */
    public $expiresIn;
    public $accessToken;
    public $idToken;
}