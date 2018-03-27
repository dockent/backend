<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 26.09.17
 * Time: 15:36
 */

use Dockent\components\DI as DIFactory;
use Dockent\components\queue\IQueueActions;
use Dockent\enums\DI;
use Dockent\enums\NotificationStatus;
use Dockent\models\db\interfaces\INotifications;
use Http\Client\Exception\HttpException;
use Phalcon\Queue\Beanstalk;
use Phalcon\Logger\AdapterInterface as LoggerInterface;

require __DIR__ . '/bootstrap.php';

/** @var Beanstalk $queue */
$queue = DIFactory::getDI()->get(DI::QUEUE);
/** @var IQueueActions $queueActions */
$queueActions = DIFactory::getDI()->get(DI::QUEUE_ACTIONS);
while (($job = $queue->reserve()) !== false) {
    $message = $job->getBody();
    try {
        $action = $message['action'];
        $queueActions->$action($message['data']);
        $job->delete();
    } catch (Exception $e) {
        /** @var LoggerInterface $logger */
        $logger = DIFactory::getDI()->get(DI::LOGGER);
        $logger->error($e->getMessage(), $e->getTrace());
        echo $message['action'] . PHP_EOL;
        echo $e->getMessage() . PHP_EOL;
        if ($e instanceof HttpException) {
            /** @var INotifications $notifications */
            $notifications = DIFactory::getDI()->get(DI::NOTIFICATIONS);
            $notifications->createNotify($e->getMessage(), NotificationStatus::ERROR);
        }
        $job->delete();
    }
}