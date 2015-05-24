<?php

namespace Flame\Classes\Http\Response;

use Flame\Abstracts\Http\Response;

class FileHandle extends Response
{
    protected $data;
    protected $contentType;

    /**
     * @param resource|string $data handle на файл или имя файла
     * @param string $contentType Заголовок Content-Type
     */
    public function __construct($data, $contentType = '')
    {
        if (!$data) {
            throw new \Exception('FileHandle $data can\'t be NULL');
        }
        $this->data = $data;
        $this->contentType = $contentType;
    }

    public function getContentType()
    {
        return $this->contentType;
    }

    public function get()
    {
        if (gettype($this->data) == 'resource') {
            return $this->data;
        }

        if (!is_string($this->data)) {
            throw new \Exception('Unsupported type ' . gettype($this->data));
        }

        if (!is_file($this->data)) {
            return false;
        }

        return fopen($this->data, 'r');
    }
}