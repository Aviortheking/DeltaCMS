<?php

/**
 * this file initialize some variables and do the first part of the routing (between public pages & admin pages)
 */

require_once "admin/system/functions.php";

ini_set('display_errors', 'On');

$url = strtolower(endsWith($_SERVER["REQUEST_URI"], "/") ? $_SERVER["REQUEST_URI"] . "index" : $_SERVER["REQUEST_URI"]);

define("URL", $url);
define("ROOT", __DIR__);


define("SETTINGS", loadJSON(ROOT . "/admin/settings/admin.json"));
// $website = new Website();
// var_dump(__DIR__);
$_SERVER = null;

if($url == "/test") {
	require_once "test.php";
	die;
}

$fileURI = "./pages" . $url . ".json";
if(in_array(explode("/", $url)[1], ["login", "admin"])) echo ("this is the login/admin page");
elseif (file_exists($fileURI)) {
	require_once "public/public.php";
} else echo "404";
/*

verify if the page to load exist
	if page is login/admin then continue;
	elif the page is a file in /pages/pagename.json then continue
	else return 404 error

verify if user is logged in
	if the user is logged in & the page is login return to /admin
	elif the user is not logged in & the page is admin return to /login
	else start the process to load the page

*/

?>
