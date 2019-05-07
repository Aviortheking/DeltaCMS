<?php

namespace DeltaCMS\Route;

class ControllerRoute extends AbstractRoute
{

    public function listOptions(): array
    {
        return array(
            'controller',
            'function',
            'args'
        );
    }

    public function render(array $args = array()): string
    {
        $controller = new $this->options["controller"]();
        $function = $this->options["function"];
        $controller->setUrlArguments($args);
        return $controller->$function();
    }
}
