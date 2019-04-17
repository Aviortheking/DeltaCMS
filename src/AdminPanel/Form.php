<?php

namespace AdminPanel;

use AdminPanel\Cache\SessionCache;

class Form
{

    private $session = null;
    private $formname = null;

    private function isSubmitting($fields)
    {
        $entity = $this->session->get("form_" . $this->formname);
        if (isset($entity)) {
            foreach (array_keys((array) $fields) as $name) {
                if (filter_input(INPUT_POST, $name) === null) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    private function addField($name, $settings)
    {
        // get class
        if (strstr($settings->type, "\\") === false) {
            $settings->type = "\\AdminPanel\\Form\\" . ucfirst($settings->type) . "Input";
        }
        /** @var \AdminPanel\Form\Input */
        $field = new $settings->type();

        $entity = $this->session->get("form_" . $this->formname);
        // dd($entity);
        $func = "get" . ucfirst($name);
        $options = array(
            'name' => $name,
            'attr' => array(),
            'label' => isset($settings->label) ? $settings->label : null,
            'value' => $entity !== null && $entity->$func() !== null ? $entity->$func() : null
        );

        $fieldOptions = array_merge(
            $field->getOptions(),
            array_keys($options)
        );

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
        $this->$name = AdminPanel::getInstance()->getTwig()->render($field->getTemplate(), $options);
    }

    public function __construct(string $formname, $entity = null)
    {
        // dd($entity);
        $cache = AdminPanel::getInstance()->getCache();
        $forms = $cache->get("forms");
        $this->session = new SessionCache();

        if (isset($forms[$formname])) {
            $this->formname = $formname;
            $form = $forms[$formname];
            if ($this->isSubmitting($form->fields)) {
                dd("submitting");
            }
            dump("not submitting");
            if (isset($form->entity) && (!isset($entity) || !($entity instanceof $form->entity))) {
                $entity = new $form->entity();
            }
            $this->session->set("form_" . $this->formname, $entity);
            foreach ($form->fields as $name => $settings) {
                $this->addField($name, $settings);
            }
        }
    }
}
