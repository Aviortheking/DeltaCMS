<?php

namespace AdminPanel;

class Form
{
    public function __construct(string $formname, $entity = null)
    {
        $ap = AdminPanel::getInstance();
        $cache = $ap->getCache();
        $forms = $cache->get("forms");
        if (isset($forms[$formname])) {
            $form = $forms[$formname];
            if (isset($form->entity) && (!isset($entity) || !($entity instanceof $form->entity))) {
                $entity = new $form->entity();
            }
            foreach ($form->fields as $name => $settings) {

                // get class
                if (strstr($settings->type, "\\") === false) {
                    $settings->type = "\\AdminPanel\\Form\\" . ucfirst($settings->type) . "Input";
                }
                /** @var \AdminPanel\Form\Input */
                $field = new $settings->type();

                $func = "get" . ucfirst($name);
                $options = array(
                    'name' => $name,
                    'type' => $settings->type,
                    'attr' => array(),
                    'label' => isset($settings->label) ? $settings->label : null,
                    'value' => $entity !== null && $entity->$func !== null ? $entity->$func : null
                );

                $fieldOptions = array_merge(
                    $field->getOptions(),
                    array_keys($options)
                );

                /*
                $settings
                $fieldOptions
                $options
                $field
                */

                foreach ($settings as $opt => $value) {
                    if (in_array($opt, $fieldOptions)) {
                        $options = array_merge(
                            $options,
                            $field->processOption($opt, $value)
                        );
                    } else {
                        $options["attr"][$opt] = $value;
                    }
                }
                $this->$name = $ap->getTwig()->display($field->getTemplate(), $options);
            }
        }
    }
}
