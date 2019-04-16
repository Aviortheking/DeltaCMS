<?php

namespace AdminPanel;

class Form
{
    private static $knownOptions = array(
        'type',
        'choices',
        'label',
        'entity'
    );

    // TODO: switch to scandir to get actual templates
    // & maybe allow the adition of other custom templates
    private static $knownTypes = array(
        'choice',
        'entity',
        'text',
        'date'
    );

    public function __construct(string $formname, $entity = null)
    {
            //check if entity is linked and $entity instanceof entity
                // do something
                // check if datas are in the entity
            // loop through the content of the form
            // check if type is in the db
                // load the template from the type
            // else
                // load the _default
                // put it in the variable with his name
        $ap = AdminPanel::getInstance();
        $cache = $ap->getCache();
        $forms = $cache->get("forms");
        if (isset($forms[$formname])) {
            $form = $forms[$formname];
            if (isset($form->entity) && (!isset($entity) || !($entity instanceof $form->entity))) {
                $entity = new $form->entity();
            }
            // dump($form->fields);
            foreach ($form->fields as $name => $settings) {
                $options = array(
                    'name' => $name,
                    'label' => null,
                    'attr' => array(),
                    'value' => null,
                    'type' => null, //used in case of formtype not found
                    'choices' => null //choiceType
                );
                if ($entity !== null) {
                    $func = "get" . ucfirst($name);
                    if ($entity->$func() !== null) {
                        $options["value"] = $entity->$func();
                    }
                }
                foreach ($settings as $opt => $value) {
                    // dump($settings);
                    if (in_array($opt, Form::$knownOptions)) {
                        if ($opt === "entity") {
                            // dd($ap->getEm()->getRepository($value)->findAll());
                            $options["entities"] = $ap->getEm()->getRepository($value)->findAll();
                        } else {
                            $options[$opt] = $value;
                        }
                    } else {
                        $options["attr"][$opt] = $value;
                    }
                }
                if (in_array($options["type"], Form::$knownTypes)) {
                    $this->$name = $ap->getTwig()->display("@AdminPanel/Form/" . $options["type"] . ".twig", $options);
                } else {
                    $this->$name = $ap->getTwig()->display("@AdminPanel/Form/_default.twig", $options);
                }
            }
        } else {
            // TODO: IDK
        }
    }
}
