#!/bin/bash
echo I am the static process script
cd /home/ubuntu/bd-site
rm -rf dist

cp -r /var/www/html/bd/dist /home/ubuntu/bd-site
git add .
git commit -am "$(date +%Y%m%d)"
git push origin master