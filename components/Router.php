<?php

class Router {

	private $routes;

	public function __construct()
	{
		$routesPath = ROOT . '/config/routes.php';
		$this->routes = include_once($routesPath);
	}


	private function getURI()
	{
		if(!empty($_SERVER['REQUEST_URI'])){
			return trim($_SERVER['REQUEST_URI'], '/');
		}
	}	

	public function run()
	{
		// получаем запрос
		$uri = $this->getURI();


		foreach($this->routes as $uriPattern => $path){
			if(preg_match("~$uriPattern~", $uri)){

				$internalRoute = preg_replace("~$uriPattern~", $path, $uri);
				$segments = explode('/', $internalRoute);

				// определяем имя контроллера
				$controllerName = array_shift($segments).'Controller';
				$controllerName = ucfirst($controllerName);

				//определяем имя action
				$actionName = 'action'.ucfirst(array_shift($segments));

				// параметры
				$parametrs = $segments;

				// подключаем контроллер
				$controllePath = ROOT . '/controllers/'.$controllerName.'.php';

				if(file_exists($controllePath)){
					include_once($controllePath);
				}

				$objectController = new $controllerName;
				$result = call_user_func_array(array($objectController, $actionName), $parametrs);

				if($result != null){
					break;
				}

			} 
		}



	}



}