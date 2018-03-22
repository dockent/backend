<?php
/**
 * @author: Vladyslav Pozdnyakov <scary_donetskiy@live.com>
 * @copyright Dockent 2017
 */

use Dockent\components\DI as DIFactory;
use Dockent\models\db\Notifications;
use Http\Client\Exception\HttpException;
use Phalcon\Debug;
use Phalcon\Mvc\Application;

require __DIR__ . '/bootstrap.php';

(new Debug())->listen();
$application = new Application(DIFactory::getDI());

try {
    $response = $application->handle();
    $response->send();
} catch (HttpException $httpException) {
    Notifications::createNotify($httpException->getMessage());
}