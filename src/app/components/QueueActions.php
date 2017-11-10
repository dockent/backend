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
use Dockent\OpenAPI\Model\ContainerConfig;

/**
 * Class QueueActions
 * @package Dockent\components
 */
final class QueueActions
{
    /**
     * @param array $data
     */
    public static function createContainer(array $data)
    {
        /** @var Connector $docker */
        $docker = DIFactory::getDI()->get(DI::DOCKER);
        $containerConfig = new ContainerConfig();
        DockerHelper::pull($data['image']);
        $containerConfig->setImage($data['image']);
        $containerConfig->setCmd($data['cmd']);
        $parameters = [];
        $name = $data['name'];
        if ($name) {
            $parameters['name'] = $name;
        }
        $containerCreateResult = $docker->ContainerResource()->containerCreate($containerConfig, $parameters);
        if (array_key_exists('start', $data)) {
            $docker->ContainerResource()->containerStart($containerCreateResult->getId());
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
     */
    public static function buildImageByDockerfilePath(string $path)
    {
        self::makeStreamByPath($path, function ($stream) {
            /** @var Connector $docker */
            $docker = DIFactory::getDI()->get(DI::DOCKER);
            $docker->ImageResource()->imageBuild($stream);
        });
    }

    /**
     * @param string $body
     */
    public static function buildByDockerfileBodyAction(string $body)
    {
        $uniquePrefix = uniqid('docker_');
        $directoryPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $uniquePrefix;
        mkdir($directoryPath);
        file_put_contents($directoryPath . DIRECTORY_SEPARATOR . 'Dockerfile', $body);
        self::buildImageByDockerfilePath($directoryPath);
    }

    /**
     * @param array $data
     */
    public static function buildByContext(array $data)
    {
        static::buildByDockerfileBodyAction(DockerComponent::generateBody($data));
    }

    /**
     * @param string $path
     * @param \Closure $worker
     */
    private static function makeStreamByPath(string $path, \Closure $worker)
    {
        $process = proc_open('/usr/bin/env tar c .', [
            ['pipe', 'r'],
            ['pipe', 'w'],
            ['pipe', 'w']
        ], $pipes, $path);
        $stream = $pipes[1];
        $worker($stream);
        proc_close($process);
        fclose($stream);
    }
}