<?php

namespace Flame\Classes;

/**
 * Получение переменных и работы с массивами GET или POST<br/>
 * @author Козленко В.Л.
 */
class RequestHttp {
    /**
     * Получает GET переменную
     * @param string $p_name название переменной
     * @param mixed $p_default значение по умолчанию, если переменной нет
     * @return string значение переменной
     */
    public function get($name, $p_default = '') {
        return isset($_GET[$name]) ? $_GET[$name] : $p_default;
    }

    /**
     * Получает значение переменной из GET массива
     * @param string $pName название переменной
     * @param integer $pDefault значение по умолчанию, если переменной нет
     * или опеределена как пустая
     * @return integer значение переменной
     */
    public function getInt($name, $pDefault = 0) {
        if (!isset($_GET[$name])) {
            return $pDefault;
        }
        return $_GET[$name] == '' ? $pDefault : (int)$_GET[$name];
    }

    /**
     * Получает значение переменной из POST массива
     * @param string $pName название переменной
     * @param integer $pDefault значение по умолчанию, если переменной нет
     * или опеределена как пустая
     * @return integer значение переменной
     */
    public function postInt($name, $pDefault = 0) {
        if (!isset($_POST[$name]))
            return $pDefault;
        return $_POST[$name] == '' ? $pDefault : (int)$_POST[$name];
    }

    /**
     * Получает POST переменную
     * @param string $pName название переменной
     * @param string $pDefault значение по умолчанию, если переменной нет
     * @return mixed значение переменной
     */
    public function post($name, $pDefault = '') {
        if (!isset($_POST[$name]))
            return $pDefault;
        $val = $_POST[$name];
        //if (get_magic_quotes_gpc($val) && !is_array($val))
        //    return stripslashes($val);
        return $val;
    }

    /**
     * Возвращает целочисленное значение переменной из GET или POST<br/>
     * С начала проверяет GET а потом POST
     * @param string $pVarName имя переменной
     * @param string $pValueDefault значение по умолчанию, если переменная не задана
     * @return integer
     */
    public function getVarInt($name, $pValueDefault = 0) {
        if (isset($_GET[$name]))
            return (int)($_GET[$name]);
        else
            return isset($_POST[$name]) ? (int)$_POST[$name] : $pValueDefault;
    }

    /**
     * Возвращает значение переменной из GET или POST<br/>
     * С начала проверяет GET а потом POST
     * @param string $pVarName имя переменной
     * @param string $pValueDefault значение по умолчанию, если переменная не задана
     * @return mixed
     */
    public function getVar($name, $pValueDefault = '') {
        if (isset($_GET[$name]))
            return ($_GET[$name]);
        else
            return isset($_POST[$name]) ? $_POST[$name] : $pValueDefault;
    }

    /**
     * Получение безопастной строки из переменных POST.<br/>
     * переменная обрабатывается htmlspecialchars
     * @param string $pName имя переменной
     * @param mixed $pDefault значение по умолчанию, если переменная не передана
     * @param integer $pQuotes
     * @return string
     */
    public function postSafe($name, $pDefault = '', $pQuotes = ENT_COMPAT) {
        return htmlspecialchars(self::post($name, $pDefault), $pQuotes);
    }

    /**
     * Возвращает TRUE, если запрос типа POST, иначе FALSE
     * @return type
     */
    public function isPost() {
        return strlen($_SERVER['REQUEST_METHOD']) == 4;
    }

    /**
     * Возвращает TRUE, если производится загрузка файла, иначе FALSE
     * @return boolean
     */
    public function isFileUpload() {
        return count($_FILES) != 0;
    }
}
