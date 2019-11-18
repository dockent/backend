<?php

namespace Dockent\queue;

use Dockent\components\docker\Docker;
use Dockent\Connector\Connector;
use Dockent\enums\NotificationStatus;
use Dockent\models\CreateContainer as CreateContainerModel;
use Dockent\models\db\NotificationsInterface;

/**
 * Class CreateContainer
 * @package Dockent\queue
 *
 * @property CreateContainerModel $data
 */
class CreateContainer extends QueueAction
{
    /**
     * @var Connector
     */
    private $connector;

    /**
     * @var Docker
     */
    private $docker;

    /**
     * @var NotificationsInterface
     */
    private $notifications;

    /**
     * CreateContainer constructor.
     * @param Connector $connector
     * @param Docker $docker
     * @param NotificationsInterface $notifications
     */
    public function __construct(Connector $connector, Docker $docker, NotificationsInterface $notifications)
    {
        $this->connector = $connector;
        $this->docker = $docker;
        $this->notifications = $notifications;
    }

    public function handle(): void
    {
        $this->docker->pull($this->data->getImage());
        $parameters = [];
        $name = $this->data->getName();
        if ($name) {
            $parameters['name'] = $name;
        }
        $containerCreateResult = json_decode($this->connector->ContainerResource()->containerCreate([
            'Image' => $this->data->getImage(),
            'Cmd' => $this->data->getCmd()
        ], $parameters));
        $this->notifications
            ->createNotify("Container {$this->data->getName()} created", NotificationStatus::SUCCESS);
        if ($this->data->isStart()) {
            $this->connector->ContainerResource()->containerStart($containerCreateResult->Id);
        }
    }
}