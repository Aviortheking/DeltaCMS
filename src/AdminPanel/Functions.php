<?php

use AdminPanel\Classes\Cache;

function ping()
{
    return "pong";
}

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
 * @return bool|array
 */
function slugEqualToURI($slug, $uri, $options)
{
    $uri = explode("/", trim($uri, "\/"));
    $slug = explode("/", trim($slug, '\/'));
    $return = array();

    if (count($uri) != count($slug)) {
        return false;
    }

    foreach ($slug as $key => $value) {
        if (preg_match("/{.+}/", $value)) {
            $elemnt = preg_replace("/{|}/", "", $value);
            $elOptions = $options->$elemnt;
            if ($elOptions->regex != null && preg_match($elOptions->regex, $uri[$key])) {
                $return[$elemnt] = $uri[$key];
                continue;
            } else {
                return false;
            }
            //TODO correspond with module settings
        } else {
            if ($value == $uri[$key]) {
                continue;
            } else {
                return false;
            }
        }
    }
    return $return;
}


function getModulesJSON()
{
    $t = array();
    $modulesDIR = "./Modules";
    $modules = array_diff(scandir($modulesDIR), array('..', '.'));
    foreach ($modules as $module) {
        $moduleDIR = $modulesDIR . "/" . $module;
        $file = $moduleDIR . "/" . strtolower($module) . ".json";
        if (is_dir($moduleDIR) && is_file($file)) {
            $json = json_decode(file_get_contents($file), true);
            if ($json) {
                $t[$module] = $json;
            }
        }
    }
    return $t;
}

function initCache()
{
    $json = getModulesJSON();
    foreach ($json as $moduleName => $moduleValues) {
        if (isset($moduleValues["routes"])) {
            //TODO
        }
        if (isset($moduleValues["templateFolder"])) {
            Cache::getInstance()->addTemplateFolder(ROOT . "/Modules/" . $moduleName . $moduleValues["templateFolder"], $moduleName);
        }
        // return $moduleValues;
    }
    return $json;
}

/**
 * Define constant.
 * (well really it's just an hack for my linter I really don't why we can't define constant in the main process)
 *
 * @param string $name constant name
 * @param mixed $value contant value
 */
function dconst(string $name, $value)
{
    define($name, $value);
}
