<?php

namespace DeltaCMS;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use DeltaCMS\Cache\FileCache;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use DeltaCMS\Logger;
use DeltaCMS\Route\Router;

class DeltaCMS
{
    /** @var DeltaCMS $instance */
    private static $instance = null;

    /** @var string $root */
    private $root = null;

    private $settings = null;

    /**
     * Get actual DeltaCMS instance
     *
     *
     * @return DeltaCMS
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            define("ROOT", dirname(dirname(__DIR__)));
            $ap = self::$instance = new self();
            $ap->root = dirname(dirname(__DIR__));
            $ap->settings = jsonc_decode($ap->root . "/config.jsonc", false);
            $ap->settings->cache->path = $ap->root . DIRECTORY_SEPARATOR . $ap->settings->cache->path . "/fs/";
            $ap->loader = new FilesystemLoader();
            $ap->addLoaderFolder($ap->root . "/src/DeltaCMS/Twig");
            // $ap->setLoader(new FilesystemLoader());
        }
        return self::$instance;
    }

    public function getRoot(): string
    {
        return $this->root;
    }

    private $router;
    public function getRouter()
    {
        return isset($this->router) ? $this->router : $this->router = new Router();
    }

    /** @var Logger $logger */
    private $logger;
    public function getLogger(): Logger
    {
        return isset($this->logger) ? $this->logger : $this->logger = new Logger($this->root . "/logs/logs.log");
    }

    /** @var \Twig\Loader\FilesystemLoader $loader */
    private $loader;

    public function addLoaderFolder(string $path, string $prefix = "DeltaCMS")
    {
        $this->loader->addPath($path, $prefix);
    }

    /** @var \Twig\Environment $twig */
    private $twig;
    public function getTwig()
    {
        return isset($this->twig) ? $this->twig : $this->twig = new Environment($this->loader, [
            'cache' => $this->isCacheEnabled() ? $this->settings->cache->path . '/twig/' : false,
            'debug' => true
        ]);
    }

    private $cache;

    /**
     * Get the cache object used Site-wide
     *
     * @return \Psr\SimpleCache\CacheInterface
     */
    public function getCache()
    {
        if (!$this->cache) {
            $driver = $this->settings->cache->driver;
            $options = $this->settings->cache->options;
            $options->path = $this->root . $this->settings->cache->path;
            $this->cache = new $driver($this->settings->cache->options);
        }
        // dd($this->cache);
        return $this->cache;
        // return $this->cache ? $this->cache : $this->cache = new FileCache(dirname($this->root) . "/cache/fs");
    }

    public function isCacheEnabled()
    {
        return $this->settings->cache->enabled == "true";
    }

    /** @var \Doctrine\ORM\EntityManager $em */
    private $em;
    public function getEm(): EntityManager
    {
        if (!isset($this->em)) {
            $config = Setup::createAnnotationMetadataConfiguration(array(
                $this->root . "/modules/Aptatio/DB"
            ), true);

            $db = $this->settings->database;
            $conn = array(
                'driver' => $db->driver,
                'host' => $db->host,
                'dbname' => $db->dbname,
                'user' => $db->user,
                'password' => $db->password
            );

            $this->em = EntityManager::create($conn, $config);
        }
        return $this->em;
    }
}
