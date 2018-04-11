<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 25.09.17
 * Time: 16:12
 */

return [
    'currentConnection' => [
        'remote_socket' => 'localhost'
    ],
    'queue' => [
        'host' => '127.0.0.1',
        'port' => 11300
    ],
    'logstash' => [
        'host' => 'logger.dockent.vados.pro',
        'port' => 5043
    ],
    'database' => [
        'adapter' => 'sqlite',
        'dbname' => __DIR__ . '/dockent.db'
    ]
];