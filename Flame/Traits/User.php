<?php

namespace Flame\Traits;

trait User
{
    /** @var \Flame\Classes\User $user */
	private $user;

	public function getUser()
	{
		return $this->user ?: $this->user = new \Flame\Classes\User();
	}
}