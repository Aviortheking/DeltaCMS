<?php

use AdminPanel\AdminPanel;

session_start();
ini_set('display_errors', 'On');

/** @var Composer\Autoload\ClassLoader $loader */
$loader = require_once __DIR__ . "/../vendor/autoload.php";

//die;
$ap = AdminPanel::getInstance();
// dd($ap);
/*
1: get all the template folders
2: match routes directly with modules
*/
$cache = $ap->getCache();
$caches = $cache->getMultiple(array(
    'routes',
    'templates',
    'forms'
));

//if cache don't exist create it!
$cachesBool = $caches["routes"] === null || $caches['templates'] === null || $caches['forms'] === null;
if (!($ap->isCacheEnabled()) || $cachesBool ) {
    $modulesDIR = __DIR__ . "/Modules";
    $modules = array_diff(scandir($modulesDIR), array('..', '.'));
    /** @var string $module */
    foreach ($modules as $module) {
        $moduleDIR = $modulesDIR . "/" . $module;
        if (is_dir($moduleDIR) && is_file($moduleDIR . "/" . strtolower($module) . ".json")) {
            $json = json_decode(file_get_contents($moduleDIR . "/" . strtolower($module) . ".json"));
            if (isset($json->templateFolder)) {
                $cache->set(
                    'templates',
                    array_merge($cache->get('templates', array()), array(
                        $module => $moduleDIR . $json->templateFolder
                    ))
                );
            }
            foreach ($json->routes as $routeName => $routeArgs) {
                if (isset($routeArgs->file)) {
                    $routeArgs->file = $moduleDIR . $routeArgs->file;
                }
                $cache->set('routes', array_merge(
                    $cache->get('routes', array()),
                    array(
                        $routeName => $routeArgs
                    )
                ));
            }
            if (isset($json->forms)) {
                foreach ($json->forms as $formName => $formArgs) {
                    $cache->set('forms', array_merge(
                        $cache->get('forms', array()),
                        array(
                            $formName => $formArgs
                        )
                    ));
                }
            }
        }
    }
    $caches = $cache->getMultiple(array(
        'routes',
        'templates'
    ));
}
//load each templates
foreach ($caches['templates'] as $key => $value) {
    $ap->addLoaderFolder($value, $key);
}
foreach ($caches['routes'] as $key => $value) {
    $args = isset($value->args) ? $value->args : new stdClass();
    $composants = slugEqualToURI($value->path, filter_input(INPUT_SERVER, "REQUEST_URI"), $args);
    // dump($composants !== false);
    if ($composants !== false) {
        if (isset($value->file)) {
            if (isset($value->type)) {
                header("Content-Type: " . $value->type . "; charset=UTF-8");
            }
            echo file_get_contents($value->file);
            die;
        }
        $loader->loadClass($value->controller);
        $function = $value->function;
        // dump($function);
        /** @var AdminPanel\Classes\Controller $controller */
        $controller = new $value->controller();
        // dd(new $routeArgs->controller());
        if ($composants) {
            $controller->setUrlArguments($composants);
        }
        // if(isset($json->templateFolder)) $controller->loadTwig($json->templateFolder);
        echo $controller->$function();
        die;
    }
}




http_response_code(404);
echo "404";
