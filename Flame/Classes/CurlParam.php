<?php

namespace Flame\Classes;


class CurlParam
{
    const CONTENT_TYPE_ULTIPART_FORM_DATA = 'ultipart/form-data';
    const CONTENT_TYPE_X_WWW_FORM_URLENCODED = 'application/x-www-form-urlencoded';

    public $contentType = self::CONTENT_TYPE_X_WWW_FORM_URLENCODED;
}