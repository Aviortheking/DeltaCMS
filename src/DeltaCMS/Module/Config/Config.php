<?php

namespace DeltaCMS\Module\Config;

use DeltaCMS\Module\Config\ConfigInterface;

class Config implements ConfigInterface
{
    public function __construct(?ConfigInterface $config = null)
    {
        if (isset($config)) {
            $this->routes = $config->getRoutes();
            $this->templateFolder = $config->getTemplateFolder();
        }
    }

    private $routes = array();
    private $templateFolder = "";
    private $forms = array();

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function setRoutes(array $routes)
    {
        $this->routes = $routes;
    }

    public function getTemplateFolder(): string
    {
        return $this->templateFolder;
    }


    public function setTemplateFolder(string $folder)
    {
        $this->templateFolder = $folder;
    }

    public function getForms(): array
    {
        return $this->forms;
    }

    public function setForms(array $forms)
    {
        $this->forms = $forms;
    }
}
