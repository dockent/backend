#!/usr/bin/env bash
beanstalkd -b /var/beanstore &
php src/queue.php &
php -S 127.0.0.1:80 -t src src/.htrouter.php