<?php

namespace ModuleName\Controller;

use DeltaCMS\Controller;
use DeltaCMS\Authentificator;

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
        }
        return "test is true";
    }
}
