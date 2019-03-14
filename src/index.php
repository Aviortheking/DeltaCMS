<?php
ini_set('display_errors', 'On');

define("ROOT", __DIR__);

use AdminPanel\Classes\Controller;

/** @var Composer\Autoload\ClassLoader $loader */
$loader = require_once ROOT . "/../vendor/autoload.php";
// var_dump($_SERVER["REQUEST_URI"] . "/");
// $_SERVER["REQUEST_URI"] = "/test/";
//get all dirs
$modulesDIR = ROOT . "/Modules";
$modules = array_diff(scandir($modulesDIR), array('..', '.'));

/** @var string $module */
foreach ($modules as $module) {
	$moduleDIR = $modulesDIR . "/" . $module;
	if (is_dir($moduleDIR)) {
		$json = json_decode(file_get_contents($moduleDIR . "/" . strtolower($module) . ".json"));
		foreach ($json->routes as $routeName => $routeArgs) {
			$args = isset($routeArgs->args) ? $routeArgs->args : new stdClass();

			if(slugEqualToURI($routeArgs->path, $_SERVER["REQUEST_URI"], $args)) {
				$loader->loadClass($routeArgs->controller);
				$function = $routeArgs->function;
				echo (new $routeArgs->controller)->$function();
				die;
			}
		}
	}
}


// echo Controller::example();

// require_once ROOT . "/system/router.php";

// define("ROUTER", Router::getRouter());
function startsWith($haystack, $needle)
{
	$length = strlen($needle);
	return (substr($haystack, 0, $length) === $needle);
}

/**
 * @param string $uri
 * @param string $slug
 * @param object $options options->regex &| options->setting
 *
 * @return bool
 */
function slugEqualToURI($slug, $uri, $options) {
	$uri = explode("/", trim($uri, "\/"));
	$slug = explode("/", trim($slug, '\/'));

	if(count($uri) != count($slug)) return false;

	foreach ($slug as $key => $value) {

		if(preg_match("/{.+}/", $value)) {
			$elemnt = preg_replace("/{|}/", "", $value);
			$elOptions = $options->$elemnt;
			if($elOptions->regex != null && preg_match($elOptions->regex, $uri[$key])) continue;
			else return false;
			//TODO correspond with module settings
		} else {
			if($value == $uri[$key]) continue;
			else return false;
		}
	}
	return true;
}
