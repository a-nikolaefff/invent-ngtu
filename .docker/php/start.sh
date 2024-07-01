#!/bin/bash

sudo service cron start
sudo /usr/bin/supervisord -c /etc/supervisord.conf
php-fpm
