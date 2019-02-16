<?php

// $doc = new DOMDocument();
// $test = "<html><body><p>pouet</p></body></html>";
// $doc->loadHTML($test);

// appendHTML($doc->getElementsByTagName("body")->item(0), "<img src=\"./\">");

// echo $doc->saveHTML();

// echo gettype(true);

// include_once "admin/system/website.php";
// $website = new Website(__DIR__);
// $website->addTemplate("Blog Page", "templates/blog.php", "page", true);

// phpinfo();

// function appendHTML(DOMNode $parent, $source) {
// 	$tmpDoc = new DOMDocument();
// 	$html = "<html><body>";
// 	$html .= $source;
// 	$html .= "</body></html>";
// 	$tmpDoc->loadHTML('<?xml encoding="UTF-8">'.$html);

// 	foreach ($tmpDoc->childNodes as $item)
// 	if ($item->nodeType == XML_PI_NODE)
// 		$tmpDoc->removeChild($item);
// 	$tmpDoc->encoding = 'UTF-8';

// 	foreach ($tmpDoc->getElementsByTagName('body')->item(0)->childNodes as $node) {
// 		$importedNode = $parent->ownerDocument->importNode($node, true);
// 		$parent->appendChild($importedNode);
// 	}
// }

?>
