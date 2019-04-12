<?php

/**
 * @author Avior <florian.bouillon@delta-wings.net>
 * @since 1.0.0
 */

namespace AdminPanel\Classes;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use AdminPanel\Cache\FileCache;
use AdminPanel\Logger\Logger;

class AdminPanel
{
    /** @var AdminPanel $instance */
    private static $instance = null;

    /**
     * Undocumented function
     *
     * @return AdminPanel
     */
    public static function getInstance()
    {
        if (!isset(AdminPanel::$instance)) {
            define("ROOT", dirname(dirname(__DIR__)));
            AdminPanel::$instance = new self();
            AdminPanel::$instance->addLoaderFolder(ROOT . "/AdminPanel/Twig");
        }
        return AdminPanel::$instance;
    }

    /** @var Logger $logger */
    private $logger;
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }
    public function getLogger(): Logger
    {
        return $this->logger;
    }

    /** @var \Twig\Loader\FileSystemLoader $loader */
    private $loader;

    public function addLoaderFolder(string $path, string $prefix = "AdminPanel")
    {
        $this->loader->addPath($path, $prefix);
    }

    /** @var \Twig\Environment $twig */
    private $twig;
    public function getTwig()
    {
        return isset($this->twig) ? $this->twig : $this->twig = new Environment($this->loader, [
            'cache' => false //dirname(ROOT) . '/cache/twig/'
        ]);
    }

    private $cache;
    public function getCache()
    {
        return $this->cache ? $this->cache : $this->cache = new FileCache(dirname(ROOT) . "/cache/fs");
    }

    public function __construct()
    {
        $this->loader = new FilesystemLoader();
    }
}
