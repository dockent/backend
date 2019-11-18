<?php

namespace Dockent\console;

use Dockent\enums\NotificationStatus;
use Dockent\models\db\NotificationsInterface;
use Dockent\queue\QueueActionInterface;
use Exception;
use Http\Client\Exception\HttpException;
use Phalcon\DiInterface;
use Phalcon\Queue\Beanstalk;
use Phalcon\Logger\AdapterInterface as LoggerInterface;
use Phalcon\Queue\Beanstalk\Job;

/**
 * Class Queue
 * @package Dockent\console
 */
class Queue implements ConsoleCommandInterface
{
    /**
     * @var DiInterface
     */
    private $di;

    /**
     * @var Beanstalk
     */
    private $beanstalk;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var NotificationsInterface
     */
    private $notifications;

    /**
     * Queue constructor.
     * @param DiInterface $di
     * @param Beanstalk $beanstalk
     * @param LoggerInterface $logger
     * @param NotificationsInterface $notifications
     */
    public function __construct(
        DiInterface $di,
        Beanstalk $beanstalk,
        LoggerInterface $logger,
        NotificationsInterface $notifications)
    {
        $this->di = $di;
        $this->beanstalk = $beanstalk;
        $this->logger = $logger;
        $this->notifications = $notifications;
    }

    public function start(): void
    {
        while (($job = $this->beanstalk->reserve()) !== false) {
            $this->processJob($job);
        }
    }

    /**
     * @param Job $job
     */
    private function processJob(Job $job)
    {
        $message = $job->getBody();
        try {
            /** @var QueueActionInterface $action */
            $action = $this->di->get($message['action']);
            $action->setData($message['data'])->handle();
        } catch (Exception $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());
            if ($e instanceof HttpException) {
                $this->notifications->createNotify($e->getMessage(), NotificationStatus::ERROR);
            }
        }
        $job->delete();
    }
}