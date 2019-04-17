<?php

namespace AdminPanel\Form;

class ChoiceInput extends AbstractInput
{
    public function getOptions(): array
    {
        return array(
            'choices'
        );
    }
}
