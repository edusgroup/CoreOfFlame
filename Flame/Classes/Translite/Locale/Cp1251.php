<?php

namespace Flame\Classes\Translite\Locale;

use Flame\Abstracts\Translite;

class Cp1251 extends Translite
{
    protected $translitCharset =
        [224 => 'a', 225 => 'b', 226 => 'v', 227 => 'g', 228 => 'd', 229 => 'e',
            184 => 'e', 230 => 'zh', 231 => 'z', 232 => 'i', 233 => 'y', 234 => 'k', 235 => 'l', 236 => 'm',
            237 => 'n', 238 => 'o', 239 => 'p', 240 => 'r', 241 => 's', 242 => 't', 243 => 'u', 244 => 'f',
            245 => 'h', 246 => 'c', 247 => 'ch', 248 => 'sh', 249 => 'shh', 250 => '', 251 => 'y', 252 => '',
            253 => 'e', 254 => 'u', 255 => 'ya', 32 => '-'];

    public function getEncoding()
    {
        return 'cp1251';
    }

    public function convert($text)
    {
        return $this->convertText($text);
    }
}
