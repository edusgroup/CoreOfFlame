<?php

namespace Flame\Classes;

use Flame\Classes\Http\Exception\Error4xx;
use Symfony\Component\Yaml\Yaml;

class Init
{
    /** @var array */
    private $routeData;
    private $vars;

    public function __constructor()
    {

    }

    public function getRouteData()
    {
        return $this->routeData;
    }

    public function isAjaxRequest()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    public function makeController($name, $classAndMethod, $matches)
    {
        $data = explode('::', $classAndMethod);
        if (count($data) < 2) {
            throw new \Exception('Bad format ' . $classAndMethod . '  #bad-format-init');
        }

        /** @var \Flame\Abstracts\BaseController $controller */
        $controller = new $data[0]($name, $this);
        $controller->initDi('file', 'yaml', $_SERVER['SITE_ROOT'] . 'conf/di.yaml');
        $controller->setBaseDir($_SERVER['SITE_ROOT']);

        if (!$controller) {
            throw new \Exception('Controller from ' . $classAndMethod . ' not found #cntrl-not-found-init');
        }

        $methodName = $data[1];
        unset($data);

        if (!method_exists($controller, $methodName)) {
            throw new \Exception('Method ' . $methodName . ' in ' . $classAndMethod . ' not found #method-not-found-init');
        }

        $controller->preInitCommon($methodName, $matches);
        $controller->setRequestType($this->isAjaxRequest());

        return $controller->run($methodName, $matches);
    }

    public function initRoute($storage, $format, $sourseName)
    {
        //$routeData = json_decode(file_get_contents($sourseName));
        $this->routeData = Yaml::parse(file_get_contents($sourseName));
        if (!$this->routeData) {
            throw new \Exception('Conf ' . $sourseName . ' is bad #bad-json-conf-init');
        }

        // Если запрос был сделан на главную страницу и такой контроллер есть, то вызываем его
        if (isset($this->routeData['index']['controller']) && $_SERVER['DOCUMENT_URI'] == '/') {
            return $this->makeController('index', $this->routeData['index']['controller'], []);
        }

        unset($this->routeData['index']);

        $this->vars = [];
        if (isset($this->routeData['vars'])) {
            $this->vars = $this->routeData['vars'];
            unset($this->routeData['vars']);
        }

        // Иначем бегаем по всем роутингам и ищем подходящий
        foreach ($this->routeData as $routeName => $item) {
            if (!isset($item['regexp']) || !$item['regexp']) {
                throw new \Exception('Regexp not set in ' . $routeName);
            }

            $regexp = $item['regexp'];

            if (isset($item['vars'])) {
                foreach ($item['vars'] as $varName => $varVal) {
                    if ($varVal[0] == '@') {
                        $globalVarName = substr($varVal, 1);
                        if (!isset($this->vars[$globalVarName])) {
                            throw new \Exception('Blobal vars ' . $globalVarName . ' not found');
                        }
                        $varVal = $this->vars[$globalVarName];
                    }

                    $regexp = str_replace('{' . $varName . '}', $varVal, $regexp);
                }
            }

            if (preg_match('#' . $regexp . '#', $_SERVER['DOCUMENT_URI'], $matches)) {
                return $this->makeController($routeName, $item['controller'], $matches);
            }
        }

        // Если ни чего не нашло и есть роутинг на 4xx ошибку, то показываем его
        /*if (isset($routeData['error4xx']['controller'])) {
            return $this->makeController('error4xx', $routeData['error4xx']['controller'], []);
        }*/

        // Вызываем 4xx ошибку
        throw new Error4xx('Controller not found', 404);
    }
}
