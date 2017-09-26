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

try {
    $response = $application->handle();
    $response->send();
} catch (Exception $e) {
    echo $e->getMessage();
}