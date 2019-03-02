<?php

class Website {

	private $root;

	private const TEMPLATEJSON = "templates.json";


	public function __construct(String $root) {
		$this->root = $root;
	}

	private function getTemplateFileURI() {
		return $this->root . "/admin/settings/" . self::TEMPLATEJSON;
	}

	public function addTemplate(String $name, String $path, String $func, $bool) {
		var_dump($_SERVER);

		$val = array(
			$name => array(
				"URI" => $path,
				"function" => $func,
				"static" => $bool
			)
		);
		if(! file_exists($this->getTemplateFileURI())) {
			file_put_contents($this->getTemplateFileURI(), json_encode($val));
		} else {
			$json = json_decode(file_get_contents($this->getTemplateFileURI()), true);
			$json = array_merge($json, $val);
			file_put_contents($this->getTemplateFileURI(), json_encode($json));
		}
	}

	public function addJS() {

	}
}
