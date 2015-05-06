<?php

namespace Flame\Classes;

use Flame\Classes\Http\Exception\Error4xx;

class Init
{
	public function __constructor()
	{
			
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
		$controller = new $data[0]($name);
        $controller->initDi('file', 'yaml',  $_SERVER['SITE_ROOT'].'conf/di.yaml');
        $controller->setBaseDir($_SERVER['SITE_ROOT']);

		if (!$controller) {
			throw new \Exception('Controller from ' . $classAndMethod . ' not found #cntrl-not-found-init');
		}
		
		$methodName = $data[1];  
		unset($data);
		
		if (!method_exists($controller, $methodName)) {
			throw new \Exception('Method '.$methodName.' in '.$classAndMethod .' not found #method-not-found-init');
		}

		$controller->preInitCommon($methodName, $matches);
        $controller->setRequestType($this->isAjaxRequest());

        return $controller->run($methodName, $matches);
	}

	public function initRoute($storage, $format, $sourseName)
	{
		//$routeData = json_decode(file_get_contents($sourseName));
        $routeData = \Symfony\Component\Yaml\Yaml::parse(file_get_contents($sourseName));
		if (!$routeData){
			throw new \Exception('Conf '.$sourseName.' is bad #bad-json-conf-init');
		}

        // Если запрос был сделан на главную страницу и такой контроллер есть, то вызываем его
        if (isset($routeData['index']['controller']) && $_SERVER['DOCUMENT_URI'] == '/') {
            return $this->makeController('index', $routeData['index']['controller'], []);
        }

        // Иначем бегаем по всем роутингам и ищем подходящий
		foreach($routeData as $name=>$item) {
			if ( $item['regexp'] && preg_match('#' . $item['regexp'] . '#', $_SERVER['DOCUMENT_URI'], $matches)) {
				return $this->makeController($name, $item['controller'], $matches);
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
