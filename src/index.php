<?php

use Dockent\enums\NotificationStatus;
use Dockent\models\db\NotificationsInterface;
use Http\Client\Exception\HttpException as HttpClientException;
use Phalcon\Debug;
use Phalcon\Mvc\Application;

require __DIR__ . '/bootstrap.php';

(new Debug())->listen();
$application = new Application($di);

try {
    $response = $application->handle();
    $response->send();
} catch (HttpClientException $httpException) {
    /** @var NotificationsInterface $notifications */
    $notifications = $di->get(NotificationsInterface::class);
    $notifications->createNotify($httpException->getMessage(), NotificationStatus::ERROR);
}