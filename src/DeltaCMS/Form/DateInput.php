<?php

namespace DeltaCMS\Form;

use DateTime;

class DateInput extends AbstractInput
{
    public function setOption(string $name, $value)
    {
        if ($name === "value" && $value !== null) {
            $this->attributes["value"] = (new DateTime($value))->format('Y-m-d');
            return;
        }
        parent::setOption($name, $value);
    }

    public function getValue($name = null)
    {
        return new DateTime($this->getValueFromPost($name));
    }
}
