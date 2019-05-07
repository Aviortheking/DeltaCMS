<?php

namespace DeltaCMS\Route;

interface RouteInterface
{

    public function getName(): string;
    public function setName(string $name);

    public function getPath(): string;
    public function setPath(string $path);

    /**
     * Process a path with variables
     *
     * @param array $vars path vars
     *
     * @return string the final path
     */
    public function processPath(array $vars): string;

    public function listOptions(): array;

    public function getOptions(): array;
    public function setOptions(array $options);

    public function render(array $args = array()): string;
}
