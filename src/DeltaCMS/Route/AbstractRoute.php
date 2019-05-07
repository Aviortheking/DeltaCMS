<?php

namespace DeltaCMS\Route;

abstract class AbstractRoute implements RouteInterface
{
    protected $name;
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    protected $path;
    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path)
    {
        $this->path = $path;
    }

    public function processPath(array $vars): string
    {
        return "WIP";
    }

    public function listOptions(): array
    {
        return array();
    }

    protected $options = array();
    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options)
    {
        foreach ($options as $option => $value) {
            if (in_array($option, $this->listOptions())) {
                $this->options[$option] = $value;
            }
        }
    }
}
