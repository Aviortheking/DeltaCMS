# Admin Panel

## Table of Content

- [Admin Panel](#admin-panel)
  - [Table of Content](#table-of-content)
  - [Description](#description)
  - [Changelog](#changelog)
  - [Themes](#themes)
    - [Templates](#templates)
    - [styles & scripts](#styles--scripts)
    - [Options](#options)
  - [Modules](#modules)
  - [Files/Folders architecture](#filesfolders-architecture)
  - [Configs files](#configs-files)
    - [page.json (in `pages` folder)](#pagejson-in-pages-folder)
    - [scripts.json & styles.json](#scriptsjson--stylesjson)
    - [admin.json](#adminjson)
    - [vars.json](#varsjson)
    - [moduleName.json & themeName.json](#modulenamejson--themenamejson)
    - [templates.json](#templatesjson)

## Description

WIP

## Changelog

see [changelog.md](./changelog.md)

## Themes

### Templates

themes works via "templates".

first a template named "page" is a must, your template can be static or not (static templates will be updated on document update while not static the templateFile will always be used)

```php
website->addTemplate("Template Name", "templateURI/from/root/page.php", "functionName", true);
```

- `"Template Name"` is the shown name
- `"templateURI"` is the file URI
- `"functionName"` is the function used
- `true` is to says to the website if this template is static or not (default to `false`)

if cache is disabled globally static or not static pages will be updated at every load

example: a template named `Blog Page` can be static while a `Blog List` shouldn't be static to load newly added blog pages

```php
website->addTemplate("Blog Page", "templates/blog.php", "page", true);
website->addTemplate("Blog List", "templates/blog.php", "list", false);
```

### styles & scripts

themes must declare each scripts & styles so they can be cached when needed

```php
website->addNewStyle("styleURI/from/style/root/page.css", "styleName", ["styleDependency"]);
website->addNewScript("scriptURI/from/script/root/page.js", "scriptName", ["scriptdependency", "JQuery"]);
```

- `"styleURI"`/`"scriptURI"` is the link to the file
- [OPTIONAL] `"styleName"`/`"scriptName"` is the name of the style/script to be used by sub-dependencies
- [OPTIONAL] `["styleDependency"]`/`["scriptDependency", "JQuery"]` are used to load theses scripts after the followed dependencies

### Options

Options are declarated in the same file than before
and will be usable in the templates files

updating an option will update the static files

```php
$optionMenu = website->addOptionsMenu("Menu Name");
```

here we create a new option menu that will be located in the admin sidebar `theme -> Options` within the tabs

- `"Menu Name"` is the shown name

```php
$optionMenu->addTextOption("Option Name", "variableName", "defaultValue", {
  "min": 1,
  "max": 16,
  "placeholder": "placeholder"
});
```

## Modules

modules will work like this in the `page.content` of the page `[moduleName variablesName="valueName"]`

the module will then receive a variable named `$modVars` that will contain `$modVars->variableName` = `valueName` and will have to return a `String` Object

To keep the document strict it's advised to use the php `DOMDocument` Object

## Files/Folders architecture

- index.php (is it really necessary ?)
- .htaccess (handle file redirection)
- router.php (handle the first route part ( separating the loading process))
- uploads/
- cache/ (public cache (won't be seen by client via .htaccess redirection))
  - .htaccess (make sure clients can't access this folder)
  - scripts.js
  - styles.css
- pages/ (NO `scripts.js` NOR `styles.css` NOR `admin` NOR `login` files must be in here)
  - .htaccess (make sure clients can't access this folder)
  - index.json (this index.json will be the root name "/")
  - slugname.json (path = "/slugname")
  - iamjson.json.json (path = "/iamjson.json" wand with a module/theme could just return json)
  - folderslug/
    - index.json (path = "/folderslug" if no index.json is given there will be a 404 error for "/folderslug" but not for the "/folderslug/pouet")
    - pouet.json (path = "/folderslug/pouet")
- admin/
  - .htaccess manage redirection for admin pages (pass throught a verify login script)
  - index.php
  - admin.js
  - admin.css
  - settings/ (settings files more infos [here](#config-files))
    - scripts.json (if cache is disabled these files will be used to get the styles & scripts)
    - styles.json (else these files are only used to create the caches files)
    - admin.json (admin settings (see admin.json section))
    - templates.json (simple name to redirect)
    - modules/
      - moduleName/
        - settings.json
        - vars.json
    - themes/
      - themeName/
        - settings.json
        - vars.json
    - admin.json (used to see what to launch on the admin side)
    - options.json (options for modules & themes to be used site-wide)
    - templates.json (store the template used on the website with a link to there .php file)
  - themes/ (when a new theme is loaded regenerate scripts.js & styles.css, an option will allow the use of direct files)
    - default/ (a default theme will be here)
      - theme.php
    - themeName/
      - theme.php (only launched on theme load, to generate cache files & admin options files)
      - public.php (launched everytime on website when page is launched (admins sections are excluded)
      - admin.php (launched everytime on admin/themename/** launch (with args like page))
      - templates/ (all folders included under are optional anc can be located somewhere else in the theme folder)
        - page.php (at least a template named "page" must exist to make the theme usable)
        - templateName.php (file launched everytime a page is loaded with the template selected)
      - css/
      - js/
  - modules/
    - default/ (a default module will be here)
      - module.php
    - moduleName/
      - module.php
      - public.php (same as theme)


## Configs files

### page.json (in `pages` folder)

```json
{
  "title": "pageTitle",
  "template": "templateName",
  "access": "typeOfAccess (public: everyone has access to the page, limited:only logged in users has access to the page, private: only the author & admins has access to the page)",
  "author": "Aviortheking",
  "content": "<h1>hello world</h1>"
}
```

### scripts.json & styles.json

```json
{
  [
    "path/to/script"
  ]
}
```

### admin.json

```json
{
  "themeUsed": "themeName",
  "modulesUsed": [
    "moduleName",
    "etc"
  ]
}
```

### vars.json

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

### moduleName.json & themeName.json

values for the options are located in the `vars.json` files

```json
{
  [
    {
      "title": "Menu Title",
      "slug": "menu-title",
      "options": {
        "textOption": {
          "type": "text",
          "name": "Option Name",
        },
        "radioOption": {
          "type": "radio",
          "name": "Radio Option",
          "values": [
            "value1",
            "value2",
            "value3"
          ],
        },
        "selectOption": {
          "type": "select",
          "name": "Select",
          "value": [
            "value1",
            "value2",
            "value3",
            "etc"
          ]
        }
      }
    },
    {
      "title": "etc"
    }
  ]
}
```

### templates.json

liste des tempplates crée par le theme

*voir si il y auras tout les themes ou seulement le theme actif*

if static is true then static webpage will be generated

```json
{
  "templateName": {
    "URI": "templates/templateName.php",
    "function": "functionName",
    "static": false
  }
}
```
