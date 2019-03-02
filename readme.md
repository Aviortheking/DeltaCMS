# Admin Panel

## Table of Content

- [Admin Panel](#admin-panel)
  - [Table of Content](#table-of-content)
  - [Description](#description)
  - [Changelog](#changelog)
  - [Modules](#modules)
    - [Routes](#routes)
      - [Usage](#usage)
    - [Menus](#menus)
      - [Usage](#usage-1)
    - [Options](#options)
      - [Usage](#usage-2)
  - [Files/Folders architecture](#filesfolders-architecture)
  - [Configs files](#configs-files)
    - [site.json](#sitejson)
    - [settings.json](#settingsjson)

## Description

WIP

## Changelog

see [changelog.md](./changelog.md)

## Modules

Modules are what that will manage the system in himself.

```php
$module = new Module();
```

Modules will have multiple constant

### Routes

sitewide (except `/admin/*`) routes can be defined and will point to a function you will have to define

#### Usage

```php
$function = function($settings) {
  return "html code";
}
$module->addRoute("/regex-to-check-for-the-page/", $function);
```

### Menus

On the admin-side you can add menus & items

#### Usage

```php
$menu = $module->addMenu("Menu Name");

$pageFunction = function($settings) {
  return "html code"; //not <html> nor <body>
}

$menu->addItem("Item Name", $pageFunction);
```


### Options

#### Usage

```php
$options = $module->addOptionItem("Item Name");

$options->addOption("Option Name", "optionName", OptionTypes::text)
$options->addOption("optionVar", OptionTypes::Text, {
  "name": "Name",
  "placeholder": "placeholder",
  "default": "defaultValue"
  // more options will come later
});


```

```js
/*
possibilité de mettre des routes qui executent des functions
ajouter des pages dans la section d'admin
(Module) to initialize & manage the module
(Menu, Item from Menu) classes to manage adminPanel elements
(Variables) class to get/set used around the website vars
(OptionsItem from Item) to have a custom page for settings
(OptionsTab, Option)

*/
$module = new Module();

$menu = $module.addMenu("menuName");
$menu.addItem("itemName", function());

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

```

## Files/Folders architecture

- .htaccess (handle file redirection)
- admin/
  - .htaccess manage redirection for admin pages (pass throught a verify login script)
  - index.php
  - admin.js
  - admin.css
  - settings/ (settings files more infos [here](#config-files))
    - site.json (adminPanel settings (see admin.json section))
    - modules/
      - moduleName/
        - settings.json
    - admin.json (used to see what to launch on the admin side)
    - options.json (options for modules & themes to be used site-wide)
    - templates.json (store the template used on the website with a link to there .php file)
  - modules/
    - default/ (a default module will be here)
      - module.php
    - moduleName/
      - module.php
      - public.php (same as theme)


## Configs files

### site.json

Site-wide settings (don't know if it will be accesible for modules)

Location: `/admin/settings/`

```json
{
  "themeUsed": "themeName",
  "modulesUsed": [
    "moduleName",
    "etc"
  ]
}
```

### settings.json

Stock the module variables

Location: `/admin/settings/modules/moduleName/`

```json
{
  "variable1": "value1",
  "list1": [
    "pouet1",
    "etc"
  ],
  "variableSet1": {
    "subVariable1": "value2"
  }
}
```
