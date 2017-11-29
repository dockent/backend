<?php
/**
 * @author: Vladyslav Pozdnyakov <scary_donetskiy@live.com>
 * @copyright Dockent 2017
 */

use Dockent\components\DI as DIFactory;
use Phalcon\Mvc\Application;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/bootstrap.php';

$application = new Application(DIFactory::getDI());

/**
 * @param int $size
 * @param int $precision
 * @return string
 */
function formatBytes(int $size, int $precision = 2): string
{
    $base = log($size, 1024);
    $suffixes = ['', 'KB', 'MB', 'GB', 'TB'];
    return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[(int)floor($base)];
}

$response = $application->handle();
$response->send();