<?php

namespace AdminPanel\Form;

class ChoiceInput extends TextInput
{
    public function getOptions(): array
    {
        return array(
            'label',
            'value',
            'choices'
        );
    }

    public function getTemplate(): string
    {
        return "@AdminPanel/form/choice.twig";
    }
}
