<?php

function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

/**
 * @param string $uri
 * @param string $slug
 * @param object $options options->regex &| options->setting
 *
 * @return bool|array
 */
function slugEqualToURI($slug, $uri, $options)
{
    $uri = explode("/", trim($uri, "\/"));
    $slug = explode("/", trim($slug, '\/'));
    $return = new stdClass();

    if (count($uri) != count($slug)) {
        return false;
    }
    foreach ($slug as $key => $value) {
        if (preg_match("/{.+}/", $value)) {
            $elemnt = preg_replace("/{|}/", "", $value);
            if (!isset($options->$elemnt)) {
                $return->$elemnt = explode("?", $uri[$key])[0];
                continue;
            }
            $elOptions = $options->$elemnt;
            if (!isset($elOptions->regex) || ($elOptions->regex != null && preg_match($elOptions->regex, $uri[$key]))) {
                $return->$elemnt = explode("?", $uri[$key])[0];
                continue;
            } else {
                return false;
            }
        } else {
            if ($value == $uri[$key]) {
                continue;
            } else {
                return false;
            }
        }
    }
    return $return;
}

function jsonc_decode($filename, $assoc = false, $depth = 512, $options = 0)
{
    return json_decode(
        preg_replace(
            '![ \t]*//.*[ \t]*[\r\n]!',
            '',
            file_get_contents($filename)
        ),
        $assoc,
        $depth,
        $options
    );
}
