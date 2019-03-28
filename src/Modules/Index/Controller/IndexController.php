<?php

namespace Index\Controller;

use AdminPanel\Classes\Controller;
use AdminPanel\Classes\AdminPanel;

class IndexController extends Controller
{

    public function index()
    {
        return AdminPanel::getInstance()->getTwig()->render("@Index/index.twig", [
            "title" => "Coming Soon"
        ]);
        // return file_get_contents($this->getModuleRoot() . "/index.html");
    }

    public function test()
    {
        return "hello " . $this->getUrlArguments()["slug"];
    }
}
