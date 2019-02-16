<?php
/**
 * The process to load a public page (located in /pages)
 */

$isCacheActive = SETTINGS["cache"];

$webPage = "<html><head><placeholder type=\"head\"/></head><body>" . getWebPage($isCacheActive) . "</body>";

//load .css & .js

$doc = new DOMDocument();
libxml_use_internal_errors(true);
$doc->loadHTML($webPage);
libxml_clear_errors();

//handle modules here

echo $doc->saveHTML();

/*

if cache is active
	if active is active load cache (scripts.js  styles.css)
	load templates.json
	if template has cache for webpage and cache exist
		load the file
	else
		launch generateWebPage()

load theme css & js


if modules are in the page
	load the modules



*/
?>
