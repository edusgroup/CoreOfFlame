<?php

namespace Flame\Classes\OAuth\OAuthBase\Yandex;


class TokenCodeResponse
{
    /** @var integer Через сколько истекёт access_token */
    public $expiresIn;
    public $accessToken;
}