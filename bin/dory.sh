#!/bin/bash
set -e

sudo mkdir -p /home/private/etc/resolver/
sudo touch /home/private/etc/resolver/hmctskm.docker

echo sh -c "# added by dory" >> /home/private/etc/resolver/hmctskm.docker
echo sh -c "nameserver 127.0.0.1" >> /home/private/etc/resolver/hmctskm.docker
echo sh -c "port 53" >> /home/private/etc/resolver/hmctskm.docker
