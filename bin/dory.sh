#!/bin/bash
set -e

sudo mkdir -m 777 -p /private/etc/resolver/
sudo touch -m 777 -p /private/etc/resolver/hmctskm.docker

echo sh -c "# added by dory" >> /private/etc/resolver/hmctskm.docker
echo sh -c "nameserver 127.0.0.1" >> /private/etc/resolver/hmctskm.docker
echo sh -c "port 53" >> /private/etc/resolver/hmctskm.docker
