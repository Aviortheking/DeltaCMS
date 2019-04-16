<?php

namespace AdminPanel;

class Authentificator
{

    /** @var Authentificator $instance */
    private static $instance = null;
    public static function getInstance()
    {
        if (!isset(Authentificator::$instance)) {
            Authentificator::$instance = new self();
        }
        return Authentificator::$instance;
    }

    private $isLoggedIn = false;
    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }
}
