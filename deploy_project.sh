#! /usr/bin/env sh

phing -f build/production/build.xml -Dbasedir=/home/vyacheslav/projects/php31 -Dhost=192.168.1.102 -Duser=local -Dpassword=local -Ddbname=php31
cd ../public_html
docker-compose up --build -d