<?php

namespace Dockent\components\queue;

use Dockent\models\CreateContainer;
use Dockent\models\DockerfileBuilder;

/**
 * Interface IQueueActions
 * @package Dockent\components\queue
 */
interface IQueueActions
{
    /**
     * @param CreateContainer $data
     */
    public function createContainer(CreateContainer $data);

    /**
     * @param string $id
     */
    public function stopContainer(string $id);

    /**
     * @param string $id
     */
    public function restartAction(string $id);

    /**
     * @param string $path
     */
    public function buildImageByDockerfilePath(string $path);

    /**
     * @param string $body
     */
    public function buildByDockerfileBodyAction(string $body);

    /**
     * @param DockerfileBuilder $data
     */
    public function buildByContext(DockerfileBuilder $data);
}