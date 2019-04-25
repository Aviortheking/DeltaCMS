<?php

namespace DeltaCMS\Form;

use DeltaCMS\DeltaCMS;

class EntityInput extends AbstractInput
{
    public function __construct()
    {
        $this->setOption("type", "text");
    }

    public function getOptionsList(): array
    {
        return array_merge(
            parent::getOptionsList(),
            array(
                'entity',
                'field'
            )
        );
    }

    public function setOption(string $name, $value)
    {
        if ($name === 'entity') {
            $this->options["entities"] = DeltaCMS::getInstance()->getEm()->getRepository($value)->findAll();
        } elseif ($name === "name") {
            $this->attributes["list"] = $value . "_list";
        }
        parent::setOption($name, $value);
    }

    public function getValue($name = null)
    {
        $repo = DeltaCMS::getInstance()->getEm()->getRepository($this->options["entity"]);
        return $repo->findOneBy(array(
            $this->options['field'] => $this->getValueFromPost($name)
        ));
    }
}
