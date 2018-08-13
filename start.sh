#!/usr/bin/env bash
beanstalkd -b /var/beanstore &
php src/queue.php &
php -S 0.0.0.0:8080 -t $(pwd)/src $(pwd)/src/.htrouter.php
