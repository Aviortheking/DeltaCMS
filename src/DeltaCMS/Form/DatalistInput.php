<?php

namespace DeltaCMS\Form;

class DatalistInput extends AbstractInput
{
    public function getOptionsList(): array
    {
        return array_merge(
            parent::getOptionsList(),
            array(
                'list'
            )
        );
    }

    public function setOption(string $name, $value)
    {
        if ($name === "name") {
            $this->attributes["list"] = $name . "_list";
        }
        parent::setOption($name, $value);
    }
}
