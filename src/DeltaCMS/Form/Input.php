<?php

namespace DeltaCMS\Form;

interface Input
{

    /**
     * Get list of used in this input
     *
     * @return array array containing options
     */
    public function getAttributesList(): array;

    /**
     * get options that will be passed into the final object
     *
     * @return void
     */
    public function getAttributes(): array;

    /**
     * Get list of options usable by this input
     *
     * @return array array containing options
     */
    public function getOptionsList(): array;

    /**
     * get options that will be passed into the final object
     *
     * @return void
     */
    public function getOptions(): array;

    /**
     * get a single option that will be passed in the final object
     * (option can either go in attributes or options)
     *
     * @param string $name option's name
     *
     * @return mixed option's value
     */
    public function getOption(string $name);

    /**
     * Process the options given by php or json
     *
     * (you can do whatever you want with it)
     *
     * @param string $name name of the option
     * @param mixed $value value of element
     *
     * @return void
     */
    public function setOption(string $name, $value);

    /**
     * Get the value from $_POST & transform it into the correct type
     *
     * @param mixed $name index used
     *
     * @return mixed
     */
    public function getValue($name = null);

    /**
     * return the html to render the current input
     *
     *
     * @return string
     */
    public function render(): string;
}
