<?php
/**
 * @author: Vladyslav Pozdnyakov <scary_donetskiy@live.com>
 * @copyright Dockent 2017
 */

use Dockent\components\DI as DIFactory;
use Dockent\enums\DI;
use Dockent\enums\NotificationStatus;
use Dockent\models\db\interfaces\INotifications;
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
    /** @var INotifications $notifications */
    $notifications = DIFactory::getDI()->get(DI::NOTIFICATIONS);
    $notifications->createNotify($httpException->getMessage(), NotificationStatus::ERROR);
}