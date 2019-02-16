<?php

function loadJSON($file) {
	return json_decode(file_get_contents($file), true);
}

function getWebPage($useCache) {
	$fileCache = ROOT . "/cache" . URL . ".html";

	if($useCache && file_exists($fileCache)) {
		return file_get_contents($fileCache);
	}

	// var_dump(URL);
	$fileURI = ROOT . "/pages" . URL . ".json";
	$json = loadJSON($fileURI);
	$template = $json["template"];

	$json["template"] = null;

	define("PAGE", $json);

	$templates = loadJSON(ROOT . "/admin/settings/templates.json");

	require_once ROOT . "/admin/themes/" . SETTINGS["theme"] . "/" . $templates[$template]["URI"];

	$function = $templates[$template]["function"];

	if(function_exists($function)) {
		$content = $function();

		if($useCache && $templates[$template]["static"]) file_put_contents($fileCache, $content);

		return $content;
	return null;
	}
}

function endsWith($haystack, $needle) {
	$length = strlen($needle);
	if ($length == 0) {
		return true;
	}

	return (substr($haystack, -$length) === $needle);
}

/*
function generateWebPage()
	load pages/page.json
	load variables for theme
	generate the basic web page
*/

?>
