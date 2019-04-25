<?php

namespace DeltaCMS\Form;

use DeltaCMS\DeltaCMS;

class ChoiceInput extends AbstractInput
{
    public function getOptionsList(): array
    {
        return array_merge(
            parent::getOptionsList(),
            array(
                'choices'
            )
        );
    }

    public function getAttributesList(): array
    {
        return array(
            'name',
            'id'
        );
    }
}
