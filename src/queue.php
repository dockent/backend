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

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/bootstrap.php';

/** @var Beanstalk $queue */
$queue = DIFactory::getDI()->get(DI::QUEUE);
while (($job = $queue->reserve()) !== false) {
    $message = $job->getBody();
    $action = $message['action'];
    QueueActions::$action($message['data']);
    $job->delete();
}