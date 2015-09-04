<?php

namespace Flame\Classes\Social\Facebook;

class FbUser
{
    public $firstName;
    public $id;
    public $email;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->firstName = $data->first_name;
        $this->email = $data->email;
    }
}
