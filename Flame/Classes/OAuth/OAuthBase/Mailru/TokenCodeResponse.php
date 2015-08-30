<?php

namespace Flame\Classes\OAuth\OAuthBase\Mailru;


use Flame\Classes\Model\Collection;

class TokenCodeResponse
{
    /** @var integer Через сколько истекёт access_token */
    public $expiresIn;

    public $refreshToken;
    public $accessToken;
    public $tokenType;
    public $userId;
}