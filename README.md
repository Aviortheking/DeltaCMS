# Admin Panel

[![build](https://img.shields.io/drone/build/DeltaCMS/Core.svg?server=https%3A%2F%2Fci.delta-wings.net&style=for-the-badge)](https://ci.delta-wings.net/DeltaCMS/Core/)
![coverage](https://img.shields.io/codacy/coverage/bf7f9ac73707426e9afc4b9daa950039.svg?style=for-the-badge)
![Code Quality](https://img.shields.io/codacy/grade/bf7f9ac73707426e9afc4b9daa950039.svg?style=for-the-badge)

## Table of Content

- [Admin Panel](#admin-panel)
  - [Table of Content](#table-of-content)
  - [Description](#description)
  - [Install](#install)
  - [Build](#build)
  - [Changelog](#changelog)
  - [Badges](#badges)
    - [Build status](#build-status)
    - [Coverage](#coverage)
    - [Code Quality](#code-quality)
  - [Dependencies](#dependencies)
  - [Development Dependencies](#development-dependencies)

## Description

WIP

## Install

Fetch the latest release from the release tab [here](https://git.delta-wings.net/DeltaCMS/Core/releases)

## Build

run this command in the terminal

```console
composer install --no-dev --optimize-autoload
```

Now point your web server to the `public` folder and tada =) your website is up

## Changelog

see [changelog.md](./changelog.md)

## Badges

We're using [shields.io](https://shields.io/) badges

### Build status

_([ci.delta-wings.net](https://ci.delta-wings.net))_

![build](https://img.shields.io/drone/build/DeltaCMS/Core.svg?server=https%3A%2F%2Fci.delta-wings.net&style=for-the-badge)
`https://img.shields.io/drone/build/DeltaCMS/Core.svg?server=https%3A%2F%2Fci.delta-wings.net&style=for-the-badge`

### Coverage

_([Codacy](https://app.codacy.com/project/Aviorleking/AdminPanel/dashboard))_

![coverage](https://img.shields.io/codacy/coverage/bf7f9ac73707426e9afc4b9daa950039.svg?style=for-the-badge)
`https://img.shields.io/codacy/coverage/bf7f9ac73707426e9afc4b9daa950039.svg?style=for-the-badge`

### Code Quality

_([Codacy](https://app.codacy.com/project/Aviorleking/AdminPanel/dashboard))_

![Code Quality](https://img.shields.io/codacy/grade/bf7f9ac73707426e9afc4b9daa950039.svg?style=for-the-badge)
`https://img.shields.io/codacy/grade/bf7f9ac73707426e9afc4b9daa950039.svg?style=for-the-badge`

## Dependencies

- [Composer](https://getcomposer.org/)
  - [PSR-3](https://www.php-fig.org/psr/psr-3), [PSR-6](https://www.php-fig.org/psr/psr-6)
  - [Twig](https://twig.symfony.com/)

## Development Dependencies

- [EditorConfig](https://editorconfig.org/)
- [Git](https://git-scm.com/)
- [Issue & Merge request templates](https://www.talater.com/open-source-templates/#/)
- [Composer](https://getcomposer.org/)
  - [PHP Codesniffer](https://github.com/squizlabs/PHP_CodeSniffer)
  - [Symfony VarDumper](https://symfony.com/doc/current/components/var_dumper.html)
  - [PHPUnit](https://phpunit.de/)
  - [PHP Mess Detector](https://phpmd.org/)
- Hosting
  - [Gitlab](https://gitlab.com/) _Project url [here](https://gitlab.com/delta-wings/adminpanel)_
  - [Gitea](https://gitea.io/) _Current server [here](https://git.delta-wings.net/Avior/AdminPanel)_
  - [Drone](https://drone.io/) _Current server [here](https://ci.delta-wings.net/)_
  - [Codacy](https://codacy.com/) _Project Dashboard [here](https://app.codacy.com/project/Aviorleking/AdminPanel/dashboard)_
