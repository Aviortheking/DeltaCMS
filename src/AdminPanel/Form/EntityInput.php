<?php

namespace AdminPanel\Form;

use AdminPanel\AdminPanel;

class EntityInput implements Input
{
    public function getOptions(): array
    {
        return array(
            'label',
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

    public function getTemplate(): string
    {
        return "@AdminPanel/form/entity.twig";
    }
}
