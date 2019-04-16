<?php

namespace Index\Controller;

use AdminPanel\Controller;
use AdminPanel\AdminPanel;

class IndexController extends Controller
{

    public function index()
    {
        return $this->render("@Index/index.twig", [
            "title" => "Coming Soon"
        ]);
        // return file_get_contents($this->getModuleRoot() . "/index.html");
    }

    public function test()
    {
        return "hello " . $this->getUrlArguments()["slug"];
    }
}
