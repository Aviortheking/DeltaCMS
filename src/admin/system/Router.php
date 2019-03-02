<?php

class Router {

	private static $instance;

	private $routeList = [];

	private function __construct() {}

	public static function getInstance() {
		if($instance !== null) {
			Router::$instance = new Self();
		}
		return Router::$instance;
	}




	public function addRoute(string $regex, $function) {
		$this->routeList[$regex] = $function;
	}

	public function search(String $route) {
		foreach ($this->routeList as $key => $value) {
			if(preg_match($key, $route)) {
				return $value;
			}
		}
		return null;
	}


}
