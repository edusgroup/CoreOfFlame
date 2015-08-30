<?php

namespace Flame\Classes\OAuth\OAuthBase;


use Flame\Classes\CurlExt;

abstract class OAuthBase
{
    /** @var CurlExt Расширенный curl */
    protected $curl;
    protected $siteId;
    protected $clientSecret;
    protected $tokenUrl;

    public function __construct($siteId, $clientSecret, $tokenUrl)
    {
        $this->curl = new CurlExt();
        $this->siteId = $siteId;
        $this->clientSecret = $clientSecret;
        $this->tokenUrl = $tokenUrl;
    }

    protected abstract function getToketCodeResponse($data);

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

        $data = @json_decode($data);
        if (isset($data->error)) {
            return null;
        }

        return $this->getToketCodeResponse($data);
    }

    /**
     * @param $refreshToken
     * @return ToketCodeResponse|null
     */
    public function getRefreshTokenCode($refreshToken)
    {
        $data = $this->curl->post($this->tokenUrl, [
            'client_id' => $this->siteId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken
        ]);

        $data = @json_decode($data);
        if (isset($data->error)) {
            return null;
        }

        return $this->getToketCodeResponse($data);
    }
}