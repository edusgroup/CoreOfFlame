<?php

namespace Flame\Classes;


use Flame\Classes\Utils\ArrayHelp;

class CurlExt
{
    const REQUEST_GET_TYPE = 'get';
    const REQUEST_POST_TYPE = 'post';

    public function get($url, $getData = [])
    {
        return $this->request(self::REQUEST_GET_TYPE, $url, $getData);
    }

    /**
     * @param string $type
     * @param string $url
     * @param CurlParam|null $paramRequest
     * @return string
     */
    public function post($url, $postData = [], $paramRequest = null)
    {
        return $this->request(self::REQUEST_POST_TYPE, $url, $postData, $paramRequest);
    }

    /**
     * @param string $type
     * @param string $url
     * @param CurlParam|null $paramRequest
     * @return string
     */
    private function request($type, $url, $postData = [], $paramRequest = null)
    {
        $paramRequest = $paramRequest ?: new CurlParam();

        $curl = curl_init();
        if ($type == self::REQUEST_GET_TYPE && $postData){
            $url .= strpos($url, '?') === false ? '?' : '&';
            $url .= (new ArrayHelp())->arrayKeyValueJoin($postData, '&');
        }

        curl_setopt($curl, CURLOPT_URL, $url);

        if ($type == self::REQUEST_POST_TYPE){
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($paramRequest->contentType == CurlParam::CONTENT_TYPE_X_WWW_FORM_URLENCODED){
                $postData = urldecode(http_build_query($postData));
            }

            curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        }

        //curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        //curl_setopt($curl, CURLOPT_VERBOSE, true);
        //curl_setopt($curl, CURLOPT_CERTINFO, true);
        //$fw = fopen('Y:\CURLOPT_STDERR.txt', 'w');
        //curl_setopt($curl, CURLOPT_STDERR, $fw);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_FTP_SSL, CURLFTPSSL_TRY);
        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }
}
