<?php

namespace Flame\Classes\Social\Ok;

class OkUser
{
    public $firstName;
    public $email;
    public $id;

    public function __construct($data)
    {
        $this->id = $data->uid;
        $this->firstName = $data->first_name;
        $this->email = $data->has_email ? null : null;
    }
}
