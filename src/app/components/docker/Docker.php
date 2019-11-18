<?php

namespace Dockent\components\docker;

use Dockent\Connector\Connector;

/**
 * Class Docker
 * @package Dockent\components\docker
 */
class Docker
{
    /**
     * @var Connector
     */
    private $connector;

    /**
     * Docker constructor.
     * @param Connector $connector
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @param string $image
     */
    public function pull(string $image): void
    {
        $image = explode(':', $image);
        $parameters = [];
        if (count($image) === 1) {
            $parameters['fromImage'] = $image[0];
            $parameters['tag'] = 'latest';
        } else {
            $parameters['fromImage'] = $image[0];
            $parameters['tag'] = $image[1];
        }
        $this->connector->ImageResource()->imageCreate(null, $parameters);
    }
}