<?php

namespace DeltaCMS\Module\Config;

interface ConfigInterface
{
    public function getRoutes(): array;

    public function getTemplateFolder(): string;
}
