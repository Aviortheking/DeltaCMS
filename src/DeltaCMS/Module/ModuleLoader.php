<?php

namespace DeltaCMS\Module;

use DeltaCMS\DeltaCMS;
use DeltaCMS\Cache\FileCache;

use stdClass;

class ModuleLoader
{
    private $dc;
    private $moduleName;

    /** @var ModuleInterface $module */
    private $module;
    private $config;
    private static $fileCache = null;
    public function __construct(string $module)
    {
        $this->moduleName = ucfirst($module);
        $this->dc = DeltaCMS::getInstance();
        $mlcc = new stdClass();
        $mlcc->path = __DIR__ . "/cache/";
        $mlcc->ttl = 0;
        if ($this::$fileCache === null) {
            $this::$fileCache = new FileCache($mlcc);
        }
        $this->config = $this::$fileCache->get($this->moduleName, array(
            'enabled' => false
        ));
        $moduleClass = "\\" . $this->moduleName . "\\" . $this->moduleName;
        $this->module = new $moduleClass();
    }

    public function isEnabled(): bool
    {
        return $this::$fileCache->get($this->moduleName, false) !== false;
    }

    public function load()
    {
        if ($this->config["enabled"] !== true) {
            $this->config["enabled"] = $this->module->enable();
            $conf = $this->module->update();
            $routes = array();
            foreach ($conf->getRoutes() as $routeName => $routeOptions) {
                if (!isset($routeOptions["type"])) {
                    $routeOptions["type"] = "\\DeltaCMS\\Route\\ControllerRoute";
                } elseif (strpos($routeOptions["type"], '\\') === false) {
                    $routeOptions["type"] = "\\DeltaCMS\\Route\\" . ucfirst($routeOptions["type"]) . "Route";
                }
                $route = new $routeOptions["type"]();
                $route->setName($routeName);
                $route->setPath($routeOptions["path"]);
                $route->setOptions($routeOptions);
                $routes[$routeName] = $route;
                DeltaCMS::getInstance()->getRouter()->setRoute($route);
            }
            $this->config["templateFolder"] = $conf->getTemplateFolder();
            $this->config["routes"] = $routes;
            $this->config["forms"] = $conf->getForms();
            $this->config["templateFolder"] = $conf->getTemplateFolder();
            $this::$fileCache->set($this->moduleName, $this->config);
        }
    }

    public function getRoutes(): array
    {
        return $this->config["routes"];
    }

    public function getTemplateFolder(): string
    {
        return isset($this->config["templateFolder"]) ? $this->config["templateFolder"] : "";
    }

    public function getForms(): array
    {
        return $this->config["forms"];
    }

    public function getModule(): ModuleInterface
    {
        return $this->module;
    }




    public static function loadAllModules(): array
    {
        $dc = DeltaCMS::getInstance();
        $modulesDir = $dc->getRoot() . "/modules/";
        $modules = scandir($modulesDir);
        if ($modules === false) {
            throw new \Exception();
        }
        $arr = array();
        $modules = array_diff($modules, array("..", "."));
        foreach ($modules as $module) {
            $mod = new self($module);
            $mod->load();
            if ($mod->getTemplateFolder()) {
                $dc->addLoaderFolder($mod->getTemplateFolder(), $mod->getModule()->getName());
            }
            $arr[] = $mod;
        }
        // dd($modules, $modulesDir);
        return $arr;
    }
}
