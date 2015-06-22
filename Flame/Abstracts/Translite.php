<?php

namespace Flame\Abstracts;

abstract class Translite
{
    protected function checkUtf8($text)
    {
        $enc = mb_detect_encoding($text, mb_list_encodings(), true);
        return $enc === 'UTF-8';
    }

    protected function convertText($text)
    {
        if (!$this->checkUtf8($text)) {
            return $text;
        }

        if (preg_match('#.#u', $text)) {
            $text = iconv('UTF-8', $this->getEncoding(), $text);
        } // if

        // Если не поставить cp1251, то strToLower не переводит в нижний регистр буквы Я и Ч (вернего регистра)
        $text = mb_strtolower($text, $this->getEncoding());

        $return = '';
        $wordLength = strlen($text);
        for ($i = 0; $i < $wordLength; $i++) {
            $char = $text[$i];
            if (($char >= 'a' && $char <= 'z') || ($char >= '0' && $char <= '9') || ($char == '-')) {
                $return .= $char;
                continue;
            }
            $ord = ord($char);

            if (isset($this->translitCharset[$ord])) {
                $return .= $this->translitCharset[$ord];
            }
        } // for($i)
        $return = preg_replace('/-{2,}/', '-', $return);
        $return = trim($return, '-');
        return $return;
    }

    public abstract function convert($text);
    public abstract function getEncoding();
}
