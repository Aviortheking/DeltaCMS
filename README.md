# Admin Panel

[![Logo (<3)](https://git.delta-wings.net/DeltaCMS/Ressources/raw/branch/master/open-graph.png)](https://delta-wings.net)

[![build](https://img.shields.io/drone/build/DeltaCMS/Core.svg?server=https%3A%2F%2Fci.delta-wings.net&style=for-the-badge)](https://ci.delta-wings.net/DeltaCMS/Core/)
![coverage](https://img.shields.io/codacy/coverage/bf7f9ac73707426e9afc4b9daa950039.svg?style=for-the-badge)
![Code Quality](https://img.shields.io/codacy/grade/bf7f9ac73707426e9afc4b9daa950039.svg?style=for-the-badge)

## Table of Content

- [Admin Panel](#admin-panel)
  - [Table of Content](#table-of-content)
  - [Description](#description)
    - [What is Delta CMS ?](#what-is-delta-cms)
  - [Install](#install)
  - [Build from source](#build-from-source)
  - [Changelog](#changelog)
  - [Badges](#badges)
    - [Build status](#build-status)
    - [Coverage](#coverage)
    - [Code Quality](#code-quality)
  - [Dependencies](#dependencies)
  - [Development Dependencies](#development-dependencies)

## Description

### What is Delta CMS ?

This is a Content Management System made to be simple for end users AND developpers with everything made into modules.
(more later)

## Install

Fetch the latest release [here](https://git.delta-wings.net/DeltaCMS/Core/releases)

Please note that releases are **pre-built** for usage so you don't need to follow the [build](#build) step

Now point your web server to the `public` folder and tada :smile: your website is up

## Build from source

Clone the project and run this command in the terminal.

```console
composer install --no-dev --optimize-autoload
```

now follow the [install](#install) guide

## Changelog

See [changelog.md](./CHANGELOG.md)

## Badges

Badges are powered by [shields.io](https://shields.io/)

### Build status

_([ci.delta-wings.net](https://ci.delta-wings.net))_

![build](https://img.shields.io/drone/build/DeltaCMS/Core.svg?server=https%3A%2F%2Fci.delta-wings.net&style=for-the-badge)
`https://img.shields.io/drone/build/DeltaCMS/Core.svg?server=https%3A%2F%2Fci.delta-wings.net&style=for-the-badge`

### Coverage

_([Codacy](https://app.codacy.com/project/Aviorleking/DeltaCMS/dashboard))_

![coverage](https://img.shields.io/codacy/coverage/bf7f9ac73707426e9afc4b9daa950039.svg?style=for-the-badge)
`https://img.shields.io/codacy/coverage/bf7f9ac73707426e9afc4b9daa950039.svg?style=for-the-badge`

### Code Quality

_([Codacy](https://app.codacy.com/project/Aviorleking/DeltaCMS/dashboard))_

![Code Quality](https://img.shields.io/codacy/grade/bf7f9ac73707426e9afc4b9daa950039.svg?style=for-the-badge)
`https://img.shields.io/codacy/grade/bf7f9ac73707426e9afc4b9daa950039.svg?style=for-the-badge`

## Dependencies

DeltaCMS is powered by all these awesome projects

- [Composer](https://getcomposer.org/)
  - [PSR-3](https://www.php-fig.org/psr/psr-3), [PSR-16](https://www.php-fig.org/psr/psr-16)
  - [Twig](https://twig.symfony.com/)

:heavy_plus_sign: DeltaCMS respect multiples [PSRs](https://www.php-fig.org/)

- [PSR-2](https://www.php-fig.org/psr/psr-2) (by extension [PSR-1](https://www.php-fig.org/psr/psr-1))
- (in-review [PSR-12](https://github.com/php-fig/fig-standards/blob/master/proposed/extended-coding-style-guide.md))
- [PSR-3](https://www.php-fig.org/psr/psr-3) `\DeltaCMS\Logger`
- [PSR-4](https://www.php-fig.org/psr/psr-4) (thanks to composer)

- [PSR-16](https://www.php-fig.org/psr/psr-16) get the cache with this `DeltaCMS::getInstance()->getCache()` or the shortcut given by the class

## Development Dependencies

- Editor Synchronization
  - [EditorConfig](https://editorconfig.org/)
- [Git](https://git-scm.com/)
- Dependency Management
  - [Composer](https://getcomposer.org/)
- Debugging (like a pro :yum:)
  - [Symfony VarDumper](https://symfony.com/doc/current/components/var_dumper.html)
- Hosting
  - [Gitlab](https://gitlab.com/) mirror _Project url [here](https://gitlab.com/delta-wings/adminpanel)_
  - [Gitea](https://gitea.io/) _Current server [here](https://git.delta-wings.net/DeltaCMS/Core)_
  - [Drone](https://drone.io/) _Current server [here](https://ci.delta-wings.net/)_
  - [Codacy](https://codacy.com/) _Project Dashboard [here](https://app.codacy.com/project/Aviorleking/DeltaCMS/dashboard)_
- Code Hosting
  - [Gitea](https://gitea.io/) (Self-hosted) instance [here](https://git.delta-wings.net/DeltaCMS/Core)
  - Mirrors
    - [Gitlab](https://gitlab.com/) Project [here](https://gitlab.com/deltacms/core)
    - [Github](https://github.com/) Project [here](https://github.com/deltacms/Core)
- Continuous integration
  - [Drone](https://drone.io/) (Self-hosted) Instance [here](https://ci.delta-wings.net/DeltaCMS/Core/)
- Code Check (Testing, Code Analytics)
  - [PHP Codesniffer](https://github.com/squizlabs/PHP_CodeSniffer)
  - [PHPUnit](https://phpunit.de/)
  - [PHP Mess Detector](https://phpmd.org/)
- Other
  - [Issue & Merge request templates](https://www.talater.com/open-source-templates/#/)
