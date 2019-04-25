<?php

namespace DeltaCMS\Form;

class NumberInput extends AbstractInput
{
    public function getAttributesList(): array
    {
        return array_merge(
            parent::getAttributesList(),
            array(
                'min',
                'max'
            )
        );
    }

    public function getValue($name = null)
    {
        return (float) $this->getValueFromPost($name);
    }
}
