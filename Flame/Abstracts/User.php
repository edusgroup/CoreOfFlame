<?php

namespace Flame\Abstracts;

use Flame\Traits\MagicAccess;

/**
 * Class User
 * @package Flame\Classes
 * @method string getId() Получаем ID пользователя
 * @method string getEmail() Получаем Email пользователя
 * @method string getNicName() Получаем NickName пользователя
 */
abstract class User
{
    use MagicAccess;

    const USER_SESSION_ID = 'user.id';

    protected $nickName_;
    //protected $_login_;
    protected $email_;
    protected $id_;

    protected $isAuth = false;

    public function isAuth()
    {
        return $this->isAuth;
    }

    public abstract function init($userDao);
}
