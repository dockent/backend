<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 26.09.17
 * Time: 15:36
 */

use Dockent\components\DI as DIFactory;
use Dockent\components\QueueActions;
use Dockent\enums\DI;
use Phalcon\Queue\Beanstalk;
use Phalcon\Logger\AdapterInterface as LoggerInterface;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/bootstrap.php';

/** @var Beanstalk $queue */
$queue = DIFactory::getDI()->get(DI::QUEUE);
while (($job = $queue->reserve()) !== false) {
    $message = $job->getBody();
    try {
        $action = $message['action'];
        QueueActions::$action($message['data']);
        $job->delete();
    } catch (Exception $e) {
        /** @var LoggerInterface $logger */
        $logger = DIFactory::getDI()->get(DI::LOGGER);
        $logger->error($e->getMessage(), $e->getTrace());
        echo $message['action'] . PHP_EOL;
        echo $e->getMessage() . PHP_EOL;
        $job->delete();
    }
}