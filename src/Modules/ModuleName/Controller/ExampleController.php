<?php

namespace ModuleName\Controller;

use AdminPanel\Classes\Controller;
use AdminPanel\Classes\Authentificator;

class ExampleController extends Controller
{

    public function example()
    {
        return "hello " . $this->getUrlArguments()["arg"] . "!";
    }

    public function index()
    {
        return "Hellow Example Controller!";
    }

    public function isLoggedIn()
    {
        if (Authentificator::getInstance()->isLoggedIn()) {
            return "test is false!";
        } else {
            return "test is true";
        }
    }
}
