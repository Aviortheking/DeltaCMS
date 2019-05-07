<?php

namespace ModuleName;

use DeltaCMS\Module\AbstractModule;
use DeltaCMS\Module\Config\ConfigInterface;
use DeltaCMS\Module\Config\Config;
use ModuleName\Controller\ExampleController;

class ModuleName extends AbstractModule
{
    public function enable(): bool
    {
        $this->logger->info(self::class . " has started!");
        return true;
    }

    public function update(?ConfigInterface $config = null): ConfigInterface
    {
        $config = new Config();
        $config->setRoutes(array(
            "example_route" => array(
                "path" => "/example",
                "controller" => ExampleController::class,
                "function" => "index"
            ),
            "example_route_with_arg" => array(
                "path" => "/example/{arg}",
                "controller" => ExampleController::class,
                "function" => "example",
                "args" => array(
                    "arg" => array(
                        'regex' => "/[a-z]+/"
                    )
                )
            )
        ));
        return $config;
    }

    public function disable()
    {
        $this->logger->info(self::class . "has Disabled");
    }
}
