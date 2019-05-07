<?php

use DeltaCMS\DeltaCMS;
use DeltaCMS\Module\ModuleLoader;

session_start();
ini_set('display_errors', 'On');

/** @var Composer\Autoload\ClassLoader $loader */
$loader = require_once dirname(__DIR__) . "/vendor/autoload.php";

$ap = DeltaCMS::getInstance();

$cache = $ap->getCache();

if (!$ap->isCacheEnabled()) {
    $cache->clear();
}

$modules = ModuleLoader::loadAllModules();
$forms = $cache->get('forms', array());
dump($forms);
foreach ($modules as $loader) {
    $forms = array_merge(
        $forms,
        $loader->getForms()
    );
}
$cache->set("forms", $forms);
dump($forms);
echo $ap->getRouter()->renderRouteByUri(filter_input(INPUT_SERVER, "REQUEST_URI"));
