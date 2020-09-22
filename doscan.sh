#!/bin/bash


sudo apt-get install -y composer php-yaml
composer update

vendor/bin/rudlvault inspect -o watchlist.unsealed.yml watchlist.yml
ls -l
docker run -t  -v /var/run/docker.sock:/var/run/docker.sock -v $(pwd):/conf -v $(pwd)/docs:/out -e CONFIG_FILE=/conf/watchlist.unsealed.yml -e STATUS_FILE=/out/security.json nfra/secscanner
