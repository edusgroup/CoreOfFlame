<?php

namespace Flame\Classes\Social\Yandex;


class YaUser
{
    public $firstName;
    public $email;
    public $id;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->firstName = $data->first_name;
        $this->email = $data->default_email;
    }
}