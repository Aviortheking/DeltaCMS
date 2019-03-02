<?php

/**
 * classe pour gerer le routage des pages
 * la variable static $router sert a utiliser le router dans plusieurs fichier
 * sans forcement avoir une obligation de nom de variable
 * de plus ils sert a garder une route unique
 */
class Router {
	//variable static pour stocker le router
	private static $router = null;

	//definit le router
	public function __construct() {
		if(Router::$router != null) {
			return Router::$router;
		} else Router::$router = $this;
	}

	//fonction static pour recuperer un router déjà crée
	public static function getRouter() {
		if(Router::$router == null) {
			Router::$router = new Router();
		}
		return Router::$router;
	}

	//liste des routes
	private $routeList = array();


	//ajout d'une route
	public function addRoute($route, $page) {
		$this->routeList[$route] = $page;
	}

	//fonction de recherche d'une route par rapport a un texte
	//return function
	public function search($path) {
		foreach ($this->routeList as $reg => $page) {
			if(preg_match($reg, $path)) {
				return $page;
			}
		}
		return function () {
			return "404";
		};
	}

	public function redirecter($source, $redirectPage) {
		$this->addRoute($source, function() {
			header("Location: " . $redirectPage);
		});
	}
}
