#!/bin/bash

set -e

sudo apt-get install -y php-yaml
curl -sS https://getcomposer.org/installer -o /tmp/composer-setup2.php
sudo php /tmp/composer-setup2.php --install-dir=/usr/local/bin --filename=composer
composer update

vendor/bin/rudlvault inspect -o watchlist.unsealed.yml watchlist.yml
ls -l
chmod 777 docs/security.json

docker run -t  -v /var/run/docker.sock:/var/run/docker.sock -v $(pwd):/conf -v $(pwd)/docs:/out -e CONFIG_FILE=/conf/watchlist.unsealed.yml -e STATUS_FILE=/out/security.json nfra/secscanner
