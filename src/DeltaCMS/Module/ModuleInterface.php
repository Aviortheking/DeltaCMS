<?php

namespace DeltaCMS\Module;

use DeltaCMS\Module\Config\ConfigInterface;

interface ModuleInterface
{
    /**
     * Load the module (ex: check requirements, etc)
     *
     * here you can check for requirement load the db items
     *
     * @return bool return if you want to finish loading the addon
     */
    public function enable(): bool;

    /**
     * update will be launch at each update statements from this
     * and other modules
     *
     * @param ConfigInterface|null $config
     *
     * @return ConfigInterface
     */
    public function update(ConfigInterface $config = null): ConfigInterface;

    /**
     * Launched when plugin get disabled
     *
     * here you can archive db
     *
     * @return void
     */
    public function disable();

    /**
     * Launched when the plugin is deleted
     *
     * this method will be launched right before the deletion of all files
     * in the module folder
     *
     * @return void
     */
    public function delete();
}
