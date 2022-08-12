#!/bin/bash
echo I am the static process script
cd /home/ubuntu/bd-site
rm -rf dist
mkdir dist

cd /var/www/html/bd
cp -r `ls /var/www/html/bd/ -A | grep -v "bd-admin"` /home/ubuntu/bd-site/dist
#cp -r /var/www/html/bd/dist /home/ubuntu/bd-site

cd /home/ubuntu/bd-site
git add .
git commit -am "$(date +%Y%m%d)"
git push origin master -f

