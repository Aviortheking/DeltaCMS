#/bin/bash

apt-get update -yqq
apt-get install -yqq zip tar
docker-php-ext-install json
pecl install xdebug
docker-php-ext-enable xdebug
curl -sS https://getcomposer.org/installer | php
php composer.phar install
