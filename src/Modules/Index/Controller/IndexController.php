<?php

namespace AdminPanel\Modules\Index\Controller;

use AdminPanel\Classes\Controller;

class IndexController extends Controller {

	public function index() {
		return "hello world!";
	}

	public function test() {
		return "test working!";
	}
}
