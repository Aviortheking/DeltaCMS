<?php

namespace DeltaCMS;

use DeltaCMS\Cache\SessionCache;
use DeltaCMS\Form\Input;

class Form
{

    private $session = null;
    private $formname = null;
    private $fields = null;

    /**
     * Check if form was submitted
     *
     * @return boolean
     */
    public function isSubmitting()
    {
        return false;
        $entity = $this->session->get("form_" . $this->formname);
        if (isset($entity)) {
            foreach (array_keys((array) $this->fields) as $name) {
                if (filter_input(INPUT_POST, $name) === null) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    private function putFieldsInEntity($entity, $fields)
    {
        foreach ($fields as $name => $settings) {
            $setter = "set" . ucfirst($name);
            $adder = "add" . ucfirst($name);
            $value = filter_input(INPUT_POST, $name);
            $field = $this->getField($settings->type);
            $value = $field->getValue();
            if (is_callable(array($entity, $setter))) {
                $entity->$setter($value);
            } elseif (is_callable(array($entity, $adder))) {
                $entity->$adder($value);
            }
        }
    }

    private function getField(string $type): Input
    {
        if (strstr($type, "\\") === false) {
            $type = "\\DeltaCMS\\Form\\" . ucfirst($type) . "Input";
        }
        return new $type();
    }

    private function addField($name, $settings)
    {
        /** @var \DeltaCMS\Form\Input */
        $field = $this->getField($settings->type);

        $entity = $this->session->get("form_" . $this->formname, null);
        $func = "get" . ucfirst($name);

        $field->setOption("name", $name);
        $entity !== null && method_exists($entity, $func) ? $field->setOption("value", $entity->$func()) : null;
        foreach ($settings as $settingName => $value) {
            $field->setOption($settingName, $value);
        }
        // dump($_POST[$name]);
        dump($name, $field->getValue());
        $this->$name = $field->render();
    }

    public function __construct(string $formname, $entity = null)
    {
        // dd($entity);
        $cache = DeltaCMS::getInstance()->getCache();
        $forms = $cache->get("forms");
        $this->session = new SessionCache();

        if (isset($forms[$formname])) {
            $this->formname = $formname;
            $form = $forms[$formname];
            $this->fields = $form->fields;
            // dd($this->fields);
            if ($this->isSubmitting()) {
                if ($entity !== null) {
                    $this->putFieldsInEntity(
                        $entity,
                        $this->fields
                    );
                }
            }
            if (isset($form->entity) && (!isset($entity) || !($entity instanceof $form->entity))) {
                $entity = new $form->entity();
            }
            // send entity to session cache
            $this->session->set("form_" . $this->formname, $entity);
            foreach ($this->fields as $name => $settings) {
                $this->addField($name, $settings);
            }
        }
    }
}
