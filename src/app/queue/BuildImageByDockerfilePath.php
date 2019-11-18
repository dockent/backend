<?php

namespace Dockent\queue;

use Dockent\Connector\Connector;
use Dockent\enums\NotificationStatus;
use Dockent\models\db\NotificationsInterface;
use Exception;

/**
 * Class BuildImageByDockerfilePath
 * @package Dockent\queue
 */
class BuildImageByDockerfilePath extends QueueAction
{
    /**
     * @var Connector
     */
    private $connector;

    /**
     * @var NotificationsInterface
     */
    private $notifications;

    /**
     * BuildImageByDockerfilePath constructor.
     * @param Connector $connector
     * @param NotificationsInterface $notifications
     */
    public function __construct(Connector $connector, NotificationsInterface $notifications)
    {
        $this->connector = $connector;
        $this->notifications = $notifications;
    }

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $this->connector->ImageResource()->build($this->data);
        $this->notifications->createNotify("Image from {$this->data} built", NotificationStatus::SUCCESS);
    }
}