<?php

namespace AdminPanel\Form;

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
}
