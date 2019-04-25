<?php

namespace AdminPanel\Form;

use DateTime;

class DateInput extends AbstractInput
{

    public function getOption(string $name)
    {
        if ($name === "value") {
            return new DateTime($this->options["name"]);
        } else {
            return parent::getOption($name);
        }
    }

    public function setOption($name, $value)
    {
        if ($name === "value") {
            $this->attributes["value"] = (new DateTime($value))->format('Y-m-d');
        } else {
            parent::setOption($name, $value);
        }
    }
}
