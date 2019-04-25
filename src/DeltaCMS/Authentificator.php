<?php

namespace DeltaCMS;

class Authentificator
{

    /** @var Authentificator $instance */
    private static $instance = null;
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private $isLoggedIn = false;
    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }
}
