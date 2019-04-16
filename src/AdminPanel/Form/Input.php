<?php

namespace AdminPanel\Form;

interface Input
{
    /**
     * get definable options in form
     * some are processed elsewhere like
     * name, value
     *
     * @return array
     */
    public function getOptions(): array;

    /**
     * run things when you got option
     *
     * @param string $optionName
     * @param mixed $value
     *
     * @return array
     */
    public function processOption(string $optionName, $value): array;

    /**
     * Get template file
     *
     * @return string
     */
    public function getTemplate(): string;
}
