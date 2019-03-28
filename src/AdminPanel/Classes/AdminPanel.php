<?php

namespace AdminPanel\Classes;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class AdminPanel
{
    /** @var AdminPanel $instance */
    private static $instance = null;
    public static function getInstance()
    {
        if (!isset(AdminPanel::$instance)) {
            AdminPanel::$instance = new self();
            Cache::getInstance()->addTemplateFolder("/AdminPanel/Twig");
            AdminPanel::$instance->addLoaderFolder(ROOT . "/AdminPanel/Twig");
        }
        return AdminPanel::$instance;
    }

    private $loader;
    public function getLoader()
    {
        return $this->loader;
    }
    public function addLoaderFolder(String $path, String $prefix = "AdminPanel")
    {
        $this->loader->addPath($path, $prefix);
    }

    /** @var \Twig\Environment $twig */
    private $twig;
    public function getTwig()
    {
        return isset($this->twig) ? $this->twig : $this->twig = new Environment($this->loader);
    }

    public function __construct()
    {
        $this->loader = new FilesystemLoader();
    }
}
