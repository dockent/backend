<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 26.09.17
 * Time: 15:29
 */

namespace Dockent\components;

use Docker\API\Model\ContainerConfig;
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
    public static function createContainer($data)
    {
        $docker = new Docker();
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
        if ($data['start']) {
            $docker->getContainerManager()->start($containerCreateResult->getId());
        }
    }
}