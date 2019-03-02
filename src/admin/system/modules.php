<?php

/*
possibilité de mettre des routes qui executent des functions
ajouter des pages dans la section d'admin
(Module) to initialize & manage the module
(Menu, Item from Menu) classes to manage adminPanel elements
(Variables) class to get/set used around the website vars
(OptionsItem from Item) to have a custom page for settings
(OptionsTab, Option)

*/

/*
menu = Module.addMenu("menuName");
menu.addItem("itemName", function());

options = Module.addOptionsMenu("name");

optionTab = options.addOptionTab("name");

optionTab.addOption("test", =enum.text);

//options added will be in the first tab named at the menu name
//if there is only one tab or no tab we won't show tabs
options.addOption("test", =enum.text);

//add options if it is equal to something
//true/false is what it must be to be shown
//with be in js i think
options.addOption("option name"=String, enum.text=enumeType, "option to check", "regex to check with", must it true or false)

*/

class Menu {

	private $items = array();

	public function __construct() {

	}

	public function addMenu(Menu $menu) {
		array_push($this->items, $menu);
	}

	public function addItem(Item $item) {
		array_push($this->items, $item);
	}
}

class Item {

	private $name;
	private $url;
	private $function;



	public function toLoad($function) {
		$this->function = $function;
	}

}

class OptionItem extends Item {
	/*

	*/
}


abstract class Module {

}
