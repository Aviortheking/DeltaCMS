<?php

namespace AdminPanel\Form;

use AdminPanel\AdminPanel;

class EntityInput extends AbstractInput
{
    public function getOptions(): array
    {
        return array(
            'entity'
        );
    }

    public function processOption(string $optionName, $value): array
    {
        if ($optionName === 'entity') {
            return array(
                'entities' => AdminPanel::getInstance()->getEm()->getRepository($value)->findAll()
            );
        }
        return array(
            $optionName => $value
        );
    }
}
