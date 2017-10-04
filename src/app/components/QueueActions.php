<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 26.09.17
 * Time: 15:29
 */

namespace Dockent\components;

use Dockent\components\DI as DIFactory;
use Dockent\enums\DI;
use Docker\API\Model\ContainerConfig;
use Docker\Context\Context;
use Docker\Context\ContextBuilder;
use Docker\Docker;
use Dockent\components\Docker as DockerHelper;

/**
 * Class QueueActions
 * @package Dockent\components
 */
class QueueActions
{
    /**
     * @param array $data
     */
    public static function createContainer(array $data)
    {
        /** @var Docker $docker */
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
        $containerCreateResult = $docker->getContainerManager()->create($containerConfig, $parameters);
        if (array_key_exists('start', $data)) {
            $docker->getContainerManager()->start($containerCreateResult->getId());
        }
    }

    /**
     * @param string $id
     */
    public static function stopContainer(string $id)
    {
        /** @var Docker $docker */
        $docker = DIFactory::getDI()->get(DI::DOCKER);
        $docker->getContainerManager()->stop($id);
    }

    /**
     * @param string $path
     */
    public static function buildImageByDockerfilePath(string $path)
    {
        $context = new Context($path);
        $inputStream = $context->toStream();
        /** @var Docker $docker */
        $docker = DIFactory::getDI()->get(DI::DOCKER);
        $docker->getImageManager()->build($inputStream);
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
        $context = new Context($directoryPath);
        /** @var Docker $docker */
        $docker = DIFactory::getDI()->get(DI::DOCKER);
        $docker->getImageManager()->build($context->toStream());
    }

    /**
     * @WIP
     * @param array $data
     */
    public static function buildByContext(array $data)
    {
        $contextBuilder = new ContextBuilder();
        $contextBuilder->from($data['from']);
        $contextBuilder->run($data['run']);
        /** @var Docker $docker */
        $docker = DIFactory::getDI()->get(DI::DOCKER);
        $docker->getImageManager()->build($contextBuilder->getContext()->toStream());
    }
}