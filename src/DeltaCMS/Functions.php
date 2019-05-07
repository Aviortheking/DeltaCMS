<?php
use PHPUnit\Runner\Exception;

function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function jsonc_decode($filename, $assoc = false, $depth = 512, $options = 0)
{
    $fileContent = file_get_contents($filename);
    if ($fileContent === false) {
        throw new Exception("File" . $filename . " is not readable or not existing", 1);
    }
    $fileContent = preg_replace(
        '![ \t]*//.*[ \t]*[\r\n]!',
        '',
        $fileContent
    );
    if ($fileContent === null) {
        throw new Exception("An error occured", 1);
    }
    return json_decode($fileContent, $assoc, $depth, $options);
}
