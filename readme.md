# Admin Panel

## Description

WIP

## Changelog

see [changelog.md](./changelog.md)

## Files/Folders architecture

- index.php (is it really necessary ?)
- .htaccess (handle file redirection)
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
            - moduleName.json
        - themes/
            - themeName.json
        - admin.list (used to see what to launch on the admin side)
        - options.list (options for modules & themes to be used site-wide)
        - templates.list (store the template used on the website with a link to there .php file)
    - themes/ (when a new theme is loaded regenerate scripts.js & styles.css, an option will allow the use of direct files)
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
        - moduleName/
            - module.php
            - public.php (same as theme)


## Configs files

### scripts.json & styles.json
```json
{
    [
        "path/to/script"
    ]
}
```
### admin.list
```json
{
    "themeUsed": "themeName",
    "modulesUsed": [
        "moduleName",
        "etc"
    ]
}
```

### moduleName.json & themeName.json
```json
{
    "variable1": "value1",
    "list1": [
        "pouet1",
        "etc"
    ]
    "variableSet1": {
        "subVariable1": "value2"
    }
}
```

### templates.list

*voir si il y auras tout les themes ou seulement le theme actif*
```json
{
    "templateName": templates/templateName.php
}
```