<?php
/**
 * @author: Vladyslav Pozdnyakov <scary_donetskiy@live.com>
 * @copyright Dockent 2017
 */

use Dockent\components\DI as DIFactory;
use Phalcon\Debug;
use Phalcon\Mvc\Application;

require __DIR__ . '/bootstrap.php';

(new Debug())->listen();
$application = new Application(DIFactory::getDI());

$response = $application->handle();
$response->send();