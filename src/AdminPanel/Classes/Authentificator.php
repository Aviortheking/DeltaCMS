<?php

namespace AdminPanel\Classes;

class Authentificator
{

    /** @var Authentificator $instance */
    private static $instance = null;
    private $isLoggedIn = false;
    public static function getInstance()
    {
        if (!isset(Authentificator::$instance)) {
            Authentificator::$instance = new self();
        }
        return Authentificator::$instance;
    }

    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }
}
