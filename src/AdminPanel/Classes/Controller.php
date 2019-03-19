<?php

namespace AdminPanel\Classes;

class Controller {

	protected $urlArguments = array();

	public function setUrlArguments($args) {
		$this->urlArguments = $args;
	}

	protected function getUrlArguments() {
		return $this->urlArguments;
	}

//TODO implements functions and variables to add functionnalities to controllers

}
