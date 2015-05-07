<?php

namespace Flame\Traits;

trait Session
{
    private function initSession()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        if (!session_start()) {
            throw new \Exception('Session not start');
        }
    }

	public function setSession($name, $value)
	{
        $this->initSession();

		$_SESSION[$name] = $value;
	}

    public function getSession($name)
    {
        $this->initSession();
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    public function removeSession($name)
    {
        if (!isset($_SESSION[$name])){
            return;
        }

        unset($_SESSION[$name]);
    }
}
