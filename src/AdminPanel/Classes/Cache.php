<?php

namespace AdminPanel\Classes;

class Cache
{
    /** @var Cache $instance */
    private static $instance = null;
    private static $folder = "../cache/";
    private static $tpFileName = "templates.json";
    private static $templates;

    public static function getInstance()
    {
        if (!isset(Cache::$instance)) {
            Cache::$instance = new self();
        }
        return Cache::$instance;
    }

    public function __construct()
    {
        if (!is_dir(Cache::$folder)) {
            mkdir(Cache::$folder);
        }
        Cache::$templates = Cache::$folder . Cache::$tpFileName;
        if (!is_file(Cache::$templates)) {
            $fp = fopen(Cache::$templates, "wb");
            fwrite($fp, "{}");
            fclose($fp);
        }
    }

    public function addTemplateFolder(string $folder, string $namespace = "AdminPanel")
    {
        $fp = fopen(Cache::$templates, "wb");
        $json = file_get_contents(Cache::$templates);
        // $json = json_decode(fread($fp, filesize(Cache::$templates)));
        $json[$folder] = $namespace;
        fwrite($fp, json_encode($json));
        fclose($fp);
    }

    public function addRoute(string $name, string $path, string $controller, string $function, $options = array())
    {
        //TODO
    }
}
