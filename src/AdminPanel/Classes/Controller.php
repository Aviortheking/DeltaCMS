<?php

namespace AdminPanel\Classes;

class Controller
{

    protected $urlArguments = array();
    protected $moduleRoot = null;

    /** @var \AdminPanel\Cache\FileCache */

    protected $cache;

    public function __construct()
    {
        $this->cache = AdminPanel::getInstance()->getCache();
    }

    public function setUrlArguments($args)
    {
        $this->urlArguments = $args;
        return $this;
    }

    protected function getUrlArguments()
    {
        return $this->urlArguments;
    }

    public function setModuleRoot($root)
    {
        $this->moduleRoot = $root;
        return $this;
    }

    protected function getModuleRoot()
    {
        return $this->moduleRoot;
    }

    protected function getHTTPGet(string $element, $default = null, $emptyAllowed = false)
    {
        return isset($_GET[$element]) && (!empty($_GET[$element]) || $emptyAllowed) ? $_GET[$element] : $default;
    }

    protected function getHTTPPost(string $element, $default = null, $emptyAllowed = false)
    {
        return isset($_POST[$element]) && (!empty($_POST[$element]) || $emptyAllowed) ? $_POST[$element] : $default;
    }

    protected function render($template, $args)
    {
        return AdminPanel::getInstance()->getTwig()->render($template, $args);
    }


//TODO: implements functions and variables to add functionnalities to controllers
}
