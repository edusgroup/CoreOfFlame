<?php

namespace Flame\Classes\Social\Google;

class GoogleUser
{
    public $firstName;
    public $id;
    public $email;
    public $verifiedEmail;
    public $name;
    public $familyName;
    public $gender;
    public $locale;
    public $picture;
    public $link;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->firstName = $data->given_name;
        $this->email = $data->email;
        $this->verifiedEmail = $data->verified_email;
        /** @var string name Имя и фамилия */
        $this->name = $data->name;
        $this->familyName = $data->family_name;
        $this->gender = $data->gender;
        $this->locale = $data->locale;
        $this->picture = $data->picture;
        $this->link = $data->link;
    }
}
