<?php

namespace Flame\Classes\OAuth\OAuthBase\Facebook;


use Flame\Classes\OAuth\OAuthBase\OAuthBase;

class OAuthFacebook extends OAuthBase
{
    const USER_DB_OAUTH_KEY = 'facebook';

    protected function getToketCodeResponse($data)
    {
        $result = new TokenCodeResponse();
        $result->expiresIn = $data['expires'];
        $result->accessToken = $data['access_token'];

        return $result;
    }

    /**
     * @param string $code Код от редиректа
     * @param string $redirectUri Страница редиректа. *По факту не используемый параметр для запроса
     * @return ToketCodeResponse|null Ответ сервера
     */
    public function getAuthorizationCode($code, $redirectUri)
    {
        $data = $this->curl->post($this->tokenUrl, [
            'client_id' => $this->siteId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirectUri
        ]);

        @parse_str($data, $data);
        if (!isset($data['access_token'])) {
            return false;
        }
        return $this->getToketCodeResponse($data);
    }
}
