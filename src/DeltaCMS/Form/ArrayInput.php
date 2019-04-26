<?php

namespace DeltaCMS\Form;

class ArrayInput extends AbstractInput
{

    public function __construct()
    {
        parent::__construct();
        $this->options = array(
            'elements' => array()
        );
        $this->setOption("type", "text");
    }

    public function getOptionsList(): array
    {
        return array_merge(
            parent::getOptionsList(),
            array(
                "array_type",
                "item",
                "script"
            )
        );
    }

    public function getAttributesList(): array
    {
        return array(
            'name',
            'id',
        );
    }

    public function setOption(string $name, $value)
    {
        if ($name === "array_type") {
            $clas = $value;
            $input = new $clas();
            $input->setOption("id", $this->attributes["name"] . "-__unique__");
            $input->setOption("name", $this->attributes["name"] . "[__unique__]");
            $this->options["data-element"] = $input;
        } elseif ($name === "item") {
            foreach ($value as $vname => $vvalue) {
                $this->options["data-element"]->setOption($vname, $vvalue);
            }
        }
        parent::setOption($name, $value);
    }

    public function getValue($name = null)
    {
        $post = filter_input_array(INPUT_POST)[$this->attributes["name"]];
        if (!isset($post) || empty($post)) {
            return array();
        }
        $clas = $this->options["array_type"];
        $arr = array();
        foreach (array_keys($post) as $name) {
            $input = new $clas();
            $input->setOption("name", $this->attributes["name"]);
            $arr[] = $input->getValue($name);
        }
        return $arr;
    }

    public function render(): string
    {
        if (array_key_exists("array_type", $this->options) &&
            array_key_exists("value", $this->options)
        ) {
            $clas = $this->options["array_type"];
            if (isset($this->options["value"])) {
                foreach ($this->options["value"] as $key => $value) {
                    $input = new $clas();
                    $input->setOption("id", $this->attributes["name"] . "-" . $key);
                    $input->setOption("name", $this->attributes["name"] . "[" . $key . "]");
                    $input->setOption("value", $value);
                    $this->options["elements"][] = $input;
                }
            }
        }
        $this->attributes["data-element"] = "<span>" . $this->options["data-element"]->render() . "</span>";
        return parent::render();
    }
}
