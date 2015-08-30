<?php

namespace Flame\Classes\Social\Vk;


class VkUser
{
    public $id;
    public $firstName;
    public $lastName;

    public function __construct($data)
    {
        $this->id = $data->uid;
        $this->firstName = $data->first_name;
        $this->lastName = $data->last_name;
    }
}
