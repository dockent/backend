<?php

namespace Dockent\queue;

/**
 * Class BuildByDockerfileBody
 * @package Dockent\queue
 */
class BuildByDockerfileBody extends QueueAction
{
    /**
     * @var BuildImageByDockerfilePath
     */
    private $buildAction;

    /**
     * BuildByDockerfileBody constructor.
     *
     * @param BuildImageByDockerfilePath $buildAction
     */
    public function __construct(BuildImageByDockerfilePath $buildAction)
    {
        $this->buildAction = $buildAction;
    }

    public function handle(): void
    {
        $uniquePrefix = uniqid('docker_');
        $directoryPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $uniquePrefix;
        mkdir($directoryPath);
        file_put_contents($directoryPath . DIRECTORY_SEPARATOR . 'Dockerfile', $this->data);
        $this->buildAction->setData($directoryPath)->handle();
        rmDirRecursive($directoryPath);
    }
}