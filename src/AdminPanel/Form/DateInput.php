<?php

namespace AdminPanel\Form;

class DateInput extends TextInput
{
    public function getOptions(): array
    {
        return array(
            'label',
            'value',
        );
    }

    public function getTemplate(): string
    {
        return "@AdminPanel/form/date.twig";
    }
}
