#!/bin/bash
set -e
cd "$(dirname ${BASH_SOURCE[0]})"
if [ "$(id -u)" != "0" ]; then
   echo "This script must be run as root" 1>&2
   exit 1
fi
apt install -y chromium-browser unar
adduser --system --no-create-home chromedriver
wget https://chromedriver.storage.googleapis.com/2.40/chromedriver_linux64.zip
unar chromedriver_linux64.zip
mv chromedriver /usr/bin/
chmod 777 /usr/bin/chromedriver
cd "$(dirname "$0")"
cp ../config_examples/chromedriver.service /etc/systemd/system/chromedriver.service
systemctl daemon-reload
systemctl enable chromedriver 
systemctl start chromedriver 
rm -f chromedriver_linux64.zip

