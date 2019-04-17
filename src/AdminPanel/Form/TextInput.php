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
        $tpName = strtolower(
            str_replace(
                "Input",
                "",
                str_split('\\', self::class)[1]
            )
        );
        return "@AdminPanel/form/" . $tpName . ".twig";
    }
}
