<?php

namespace DeltaCMS\Module;

use DeltaCMS\Module\Config\Config;
use DeltaCMS\Module\Config\ConfigInterface;
use DeltaCMS\DeltaCMS;

abstract class AbstractModule implements ModuleInterface
{
    /** @var \DeltaCMS\Logger $logger */
    protected $logger;

    public function __construct()
    {
        $this->logger = DeltaCMS::getInstance()->getLogger();
    }

    public function enable(): bool
    {
        return true;
    }

    public function update(ConfigInterface $config = null): ConfigInterface
    {
        return new Config($config);
    }

    public function disable()
    {
        return;
    }

    public function delete()
    {
        return;
    }

    public function getName(): string
    {
        $name = explode("\\", get_class($this));
        $name = $name[count($name) - 1];

        return $name;
    }
}
