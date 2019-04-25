<?php

namespace AdminPanel\Form;

use AdminPanel\AdminPanel;

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
                'entity'
            )
        );
    }

    public function setOption(string $name, $value)
    {
        if ($name === 'entity') {
            $this->options["entities"] = AdminPanel::getInstance()->getEm()->getRepository($value)->findAll();
        } elseif ($name === "name") {
            $this->attributes["list"] = $value . "_list";
        }
        parent::setOption($name, $value);
    }

    public function getOption($name)
    {
        if ($name === "value") {
            $repo = AdminPanel::getInstance()->getEm()->getRepository($this->options["entity"]);
            return $repo->findOneBy(array(
                'name' => $this->options["value"]
            ));
        } else {
            return parent::getOption($name);
        }
    }
}
