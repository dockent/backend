<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 26.09.17
 * Time: 15:29
 */

namespace Dockent\components;

use Dockent\components\DI as DIFactory;
use Dockent\components\Docker as DockerComponent;
use Dockent\components\queue\IQueueActions;
use Dockent\Connector\Connector;
use Dockent\enums\DI;
use Dockent\components\Docker as DockerHelper;
use Dockent\enums\NotificationStatus;
use Dockent\models\CreateContainer;
use Dockent\models\db\interfaces\INotifications;
use Dockent\models\DockerfileBuilder;

/**
 * Class QueueActions
 * @package Dockent\components
 */
final class QueueActions implements IQueueActions
{
    /**
     * @param CreateContainer $data
     */
    public function createContainer(CreateContainer $data)
    {
        /** @var Connector $docker */
        $docker = DIFactory::getDI()->get(DI::DOCKER);
        DockerHelper::pull($data->getImage());
        $parameters = [];
        $name = $data->getName();
        if ($name) {
            $parameters['name'] = $name;
        }
        $containerCreateResult = json_decode($docker->ContainerResource()->containerCreate([
            'Image' => $data->getImage(),
            'Cmd' => $data->getCmd()
        ], $parameters));
        /** @var INotifications $notifications */
        $notifications = DIFactory::getDI()->get(DI::NOTIFICATIONS);
        $notifications->createNotify("Container {$data->getName()} created", NotificationStatus::SUCCESS);
        if ($data->isStart()) {
            $docker->ContainerResource()->containerStart($containerCreateResult->Id);
        }
    }

    /**
     * @param string $id
     */
    public function stopContainer(string $id)
    {
        /** @var Connector $docker */
        $docker = DIFactory::getDI()->get(DI::DOCKER);
        $docker->ContainerResource()->containerStop($id);
    }

    /**
     * @param string $id
     */
    public function restartAction(string $id)
    {
        /** @var Connector $docker */
        $docker = DIFactory::getDI()->get(DI::DOCKER);
        $docker->ContainerResource()->containerRestart($id);
    }

    /**
     * @param string $path
     * @throws \Exception
     */
    public function buildImageByDockerfilePath(string $path)
    {
        /** @var Connector $docker */
        $docker = DIFactory::getDI()->get(DI::DOCKER);
        $docker->ImageResource()->build($path);
        /** @var INotifications $notifications */
        $notifications = DIFactory::getDI()->get(DI::NOTIFICATIONS);
        $notifications->createNotify("Image from {$path} built", NotificationStatus::SUCCESS);
    }

    /**
     * @param string $body
     * @throws \Exception
     */
    public function buildByDockerfileBodyAction(string $body)
    {
        $uniquePrefix = uniqid('docker_');
        $directoryPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $uniquePrefix;
        mkdir($directoryPath);
        file_put_contents($directoryPath . DIRECTORY_SEPARATOR . 'Dockerfile', $body);
        $this->buildImageByDockerfilePath($directoryPath);
        rmDirRecursive($directoryPath);
    }

    /**
     * @param DockerfileBuilder $data
     * @throws \Exception
     */
    public function buildByContext(DockerfileBuilder $data)
    {
        $this->buildByDockerfileBodyAction(DockerComponent::generateBody($data));
    }
}