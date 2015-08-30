<?php

namespace Flame\Classes\Social\Mailru;

class UserInfo
{
    public $id;
    public $email;
    public $name;

    public function __construct($data)
    {
        $this->id = $data->uid;
        $this->email = $data->email;
        $this->name = $data->first_name;
    }
}
