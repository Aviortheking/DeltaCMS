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
}
