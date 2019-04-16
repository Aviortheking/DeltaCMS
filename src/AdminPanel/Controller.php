<?php

namespace AdminPanel;

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
        $input = filter_input(INPUT_GET, $element);
        return isset($input) && (!empty($input) || $emptyAllowed) ? $input : $default;
    }

    protected function getHTTPPost(string $element, $default = null, $emptyAllowed = false)
    {
        $input = filter_input(INPUT_POST, $element);
        return isset($input) && (!empty($input) || $emptyAllowed) ? $input : $default;
    }

    protected function render($template, $args)
    {
        return AdminPanel::getInstance()->getTwig()->render($template, $args);
    }

    protected function getEM()
    {
        return AdminPanel::getInstance()->getEM();
    }


//TODO: implements functions and variables to add functionnalities to controllers
}
