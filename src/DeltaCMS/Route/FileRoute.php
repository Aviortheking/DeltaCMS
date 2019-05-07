<?php

namespace DeltaCMS\Route;

use DeltaCMS\DeltaCMS;

class FileRoute extends AbstractRoute
{
    public function listOptions(): array
    {
        return array(
            'file',
        );
    }

    /**
     * Undocumented function
     *
     * @param array $args
     *
     * @return string
     */
    public function render(array $args = array()): string
    {
        $string = file_get_contents($this->options["file"]);
        return $string !== false ? $string : "";
    }
}
