<?php

namespace Flame\Classes;

class User
{
	protected $_nickName_;
	protected $_login_;
	protected $_email_;
	protected $_id_;
	
	protected $isAuth;
	
	public function __contruct()
	{
		$this->_id_ = isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
		
		$this->isAuth = (boolean) $this->_id_;
	}
	
	public function isAuth()
	{
		return $this->isAuth;
	}
	
	public function init()
	{
		
	}
}
