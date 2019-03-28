<?php

use AdminPanel\Classes\AdminPanel;
use AdminPanel\Classes\Cache;

session_start();
ini_set('display_errors', 'On');

/** @var Composer\Autoload\ClassLoader $loader */
$loader = require_once __DIR__ . "/../vendor/autoload.php";
// var_dump($_SERVER["REQUEST_URI"] . "/");
// $_SERVER["REQUEST_URI"] = "/test/";
//get all dirs
$modulesDIR = __DIR__ . "/Modules";
$modules = array_diff(scandir($modulesDIR), array('..', '.'));

dconst("ROOT", __DIR__);

initCache();
/*
1: get all the template folders
2: match routes directly with modules
*/



/** @var string $module */
foreach ($modules as $module) {
    $moduleDIR = $modulesDIR . "/" . $module;
    if (is_dir($moduleDIR)) {
        $json = json_decode(file_get_contents($moduleDIR . "/" . strtolower($module) . ".json"));
        foreach ($json->routes as $routeName => $routeArgs) {
            $args = isset($routeArgs->args) ? $routeArgs->args : new stdClass();
            $composants = slugEqualToURI($routeArgs->path, $_SERVER["REQUEST_URI"], $args);
            // dump($composants !== false);
            if ($composants !== false) {
                if (isset($json->templateFolder)) {
                    AdminPanel::getInstance()->addLoaderFolder($moduleDIR . $json->templateFolder, $module);
                }
                if (isset($routeArgs->file)) {
                    if (isset($routeArgs->type)) {
                        header("Content-Type: " . $routeArgs->type . "; charset=UTF-8");
                    }
                    echo file_get_contents($moduleDIR . $routeArgs->file);
                    die;
                }
                $loader->loadClass($routeArgs->controller);
                $function = $routeArgs->function;
                // dump($function);
                /** @var AdminPanel\Classes\Controller $controller */
                $controller = new $routeArgs->controller;
                $controller->setUrlArguments($composants);
                $controller->setModuleRoot($moduleDIR);
                // if(isset($json->templateFolder)) $controller->loadTwig($json->templateFolder);
                echo $controller->$function();
                die;
            }
        }
    }
}

http_response_code(404);
// dd();
echo "404";
die;
