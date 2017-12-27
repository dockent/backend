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
use Dockent\Connector\Connector;
use Dockent\enums\DI;
use Dockent\components\Docker as DockerHelper;
use Dockent\models\CreateContainer;

/**
 * Class QueueActions
 * @package Dockent\components
 */
final class QueueActions
{
    /**
     * @param CreateContainer $data
     */
    public static function createContainer(CreateContainer $data)
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
        if ($data->isStart()) {
            $docker->ContainerResource()->containerStart($containerCreateResult->Id);
        }
    }

    /**
     * @param string $id
     */
    public static function stopContainer(string $id)
    {
        /** @var Connector $docker */
        $docker = DIFactory::getDI()->get(DI::DOCKER);
        $docker->ContainerResource()->containerStop($id);
    }

    /**
     * @param string $id
     */
    public static function restartAction(string $id)
    {
        /** @var Connector $docker */
        $docker = DIFactory::getDI()->get(DI::DOCKER);
        $docker->ContainerResource()->containerRestart($id);
    }

    /**
     * @param string $path
     * @throws \Exception
     */
    public static function buildImageByDockerfilePath(string $path)
    {
        /** @var Connector $docker */
        $docker = DIFactory::getDI()->get(DI::DOCKER);
        $docker->ImageResource()->build($path);
    }

    /**
     * @param string $body
     * @throws \Exception
     */
    public static function buildByDockerfileBodyAction(string $body)
    {
        $uniquePrefix = uniqid('docker_');
        $directoryPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $uniquePrefix;
        mkdir($directoryPath);
        file_put_contents($directoryPath . DIRECTORY_SEPARATOR . 'Dockerfile', $body);
        self::buildImageByDockerfilePath($directoryPath);
        rmDirRecursive($directoryPath);
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    public static function buildByContext(array $data)
    {
        static::buildByDockerfileBodyAction(DockerComponent::generateBody($data));
    }
}