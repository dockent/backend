#!/usr/bin/env bash
beanstalkd -b /var/beanstore &
php src/queue.php &
php -S 0.0.0.0:80 -t src .htrouter.php