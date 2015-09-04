<?php

namespace Flame\Classes\Social\Mailru;

class UserInfo
{
    public $id;
    public $email;
    public $firstName;

    public function __construct($data)
    {
        $this->id = $data->uid;
        $this->email = $data->email;
        $this->firstName = $data->first_name;
    }
}
