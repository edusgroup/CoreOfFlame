<?php

namespace Flame\Traits;

trait Session
{
    /**
     * Инициализируем сессиию
     *
     * @throws \Exception Если сессия не запустилась
     */
    private function initSession()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        if (!session_start()) {
            throw new \Exception('Session not start');
        }
    }

    /**
     * Устанавливаем переменнную сессии
     *
     * @param $name Имя сессии
     * @param $value Значение сессии
     * @throws \Exception Если сессия не установилась
     */
	public function setSession($name, $value)
	{
        $this->initSession();

		$_SESSION[$name] = $value;
	}

    /**
     * Получаем сессию
     *
     * @param $name имя сессии
     * @return null|mixed null если ни чего не найдено
     * @throws \Exception  Если сессия не установилась
     */
    public function getSession($name)
    {
        $this->initSession();
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    /**
     * Удаляем сессию
     *
     * @param $name Имя сессии
     */
    public function removeSession($name)
    {
        if (!isset($_SESSION[$name])){
            return;
        }

        unset($_SESSION[$name]);
    }
}
