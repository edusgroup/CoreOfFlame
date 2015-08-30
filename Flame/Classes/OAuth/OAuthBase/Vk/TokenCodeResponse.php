<?php

namespace Flame\Classes\OAuth\OAuthBase\Vk;


use Flame\Classes\Model\Collection;

class TokenCodeResponse
{
    /** @var integer Через сколько истекёт access_token */
    public $expiresIn;
    public $accessToken;
    public $userId;
    public $email;
}