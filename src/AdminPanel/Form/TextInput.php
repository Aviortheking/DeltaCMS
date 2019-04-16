<?php

namespace AdminPanel\Form;

class TextInput implements Input
{

    public function getOptions(): array
    {
        return array(
        );
    }

    public function processOption(string $optionName, $value): array
    {
        return array($optionName => $value);
    }

    public function getTemplate(): string
    {
        return "@AdminPanel/form/text.twig";
    }
}
