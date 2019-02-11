<?php



$url = strtolower(endsWith($_SERVER["REQUEST_URI"], "/") ? $_SERVER["REQUEST_URI"] . "index" : $_SERVER["REQUEST_URI"]);

if($url == "/test") {
	require_once "test.php";
	die;
}

$_SERVER = null;
$fileURI = "./pages" . $url . ".json";
if(in_array(explode("/", $url)[1], ["login", "admin"])) echo ("this is the login/admin page");
elseif (file_exists($fileURI)) {
	$json = json_decode(file_get_contents($fileURI));
	echo ($json->title);
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



























function endsWith($haystack, $needle) {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

?>