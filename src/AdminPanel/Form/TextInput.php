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
        $arr = explode('\\', self::class);
        $tpName = strtolower(
            str_replace(
                "Input",
                "",
                $arr[count($arr) - 1]
            )
        );
        return "@AdminPanel/form/" . $tpName . ".twig";
    }
}
