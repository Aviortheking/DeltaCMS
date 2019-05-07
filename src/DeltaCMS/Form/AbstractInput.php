<?php

namespace DeltaCMS\Form;

use DeltaCMS\DeltaCMS;

/**
 * this abstract class has default functionnality for all working
 * before doing `parent::function` please see what it does
 */
abstract class AbstractInput implements Input
{

    protected $attributes = array();
    protected $options = array();

    public function __construct()
    {
        $arr = explode('\\', get_class($this));
        $this->setOption("type", strtolower(
            str_replace(
                "Input",
                "",
                $arr[count($arr) - 1]
            )
        ));
    }

    public function getAttributesList(): array
    {
        return array(
            'name',
            'type',
            'id',
            'value',
            'placeholder',
            'style',
            'disabled'
        );
    }


    public function getOptionsList(): array
    {
        return array(
            'label',
            'value'
        );
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getOption(string $name)
    {
        return $this->options[$name];
    }

    public function setOption(string $name, $value)
    {
        if (in_array($name, $this->getOptionsList())) {
            $this->options[$name] = $value;
        }
        if (in_array($name, $this->getAttributesList())) {
            if (in_array($name, array("id", "name")) &&
                !array_key_exists("id", $this->attributes) &&
                !array_key_exists("name", $this->attributes)
            ) {
                $this->attributes["name"] = $value;
                $this->attributes["id"] = $value;
            }
            $this->attributes[$name] = $value;
        }
    }

    protected function getValueFromPost($name = null)
    {
        if ($name !== null) {
            return filter_input_array(INPUT_POST)[$this->attributes["name"]][$name];
        }
        return filter_input(INPUT_POST, $this->attributes["name"]);
    }

    public function getValue($name = null)
    {
        return $this->getValueFromPost($name);
    }

    public function render(): string
    {
        $arr = explode('\\', get_class($this));
        $tpName = strtolower(
            str_replace(
                "Input",
                "",
                $arr[count($arr) - 1]
            )
        );
        return $this->getTwig()->render(
            "@DeltaCMS/form/" . $tpName . ".twig",
            array(
                'attributes' => $this->attributes,
                'options' => $this->options
            )
        );
    }

    protected function getTwig()
    {
        return DeltaCMS::getInstance()->getTwig();
    }
}
