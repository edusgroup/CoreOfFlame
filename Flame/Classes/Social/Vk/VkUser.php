<?php

namespace Flame\Classes\Social\Vk;


class VkUser
{
    public $id;
    public $firstName;
    public $email;

    public function __construct($data)
    {
        $this->id = $data->uid;
        $this->firstName = $data->first_name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
}
