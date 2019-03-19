<?php

namespace Index\Controller;

use AdminPanel\Classes\Controller;

class IndexController extends Controller {

	public function index() {
		return "hello world!";
	}

	public function test() {
		var_dump($this->getUrlArguments());
		return "test working!";
	}
}
