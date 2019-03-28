<?php

namespace AdminPanel\Classes;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Controller
{

    protected $urlArguments = array();
    protected $moduleRoot = null;

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

//TODO implements functions and variables to add functionnalities to controllers
}
