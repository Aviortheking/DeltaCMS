<?php

/**
 * @author Avior <florian.bouillon@delta-wings.net>
 * @since 1.0.0
 */

namespace DeltaCMS;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use DeltaCMS\Cache\FileCache;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use DeltaCMS\Logger;

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
     * @param array $settings
     * Settings to set to the software
     *
     * @return DeltaCMS
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            define("ROOT", dirname(dirname(__DIR__)));
            $ap = self::$instance = new self();
            $ap->root = dirname(__DIR__);
            $ap->settings = jsonc_decode(dirname($ap->root) . "/config.jsonc", false);
            $ap->loader = new FilesystemLoader();
            $ap->addLoaderFolder($ap->root . "/DeltaCMS/Twig");
            // $ap->setLoader(new FilesystemLoader());
        }
        return self::$instance;
    }

    /** @var Logger $logger */
    private $logger;
    public function getLogger(): Logger
    {
        return isset($this->logger) ? $this->logger : $this->logger = new Logger(dirname($this->root));
    }

    /** @var \Twig\Loader\FileSystemLoader $loader */
    private $loader;
    // private function setLoader(FilesystemLoader $loader)
    // {
    //     $this->loader = $loader;
    // }

    public function addLoaderFolder(string $path, string $prefix = "DeltaCMS")
    {
        $this->loader->addPath($path, $prefix);
    }

    /** @var \Twig\Environment $twig */
    private $twig;
    public function getTwig()
    {
        return isset($this->twig) ? $this->twig : $this->twig = new Environment($this->loader, [
            'cache' => $this->isCacheEnabled() ? dirname($this->root) . $this->settings->cache->path . '/twig/' : false
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
            $options->path = dirname($this->root) . $this->settings->cache->path;
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

    private $em;
    public function getEm()
    {
        if (!isset($this->em)) {
            $config = Setup::createAnnotationMetadataConfiguration(array(
                $this->root . "/Modules/Aptatio/DB"
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
