<?php

namespace Dockent\queue;

use Dockent\Connector\Connector;

/**
 * Class RestartContainer
 * @package Dockent\queue
 */
class RestartContainer extends QueueAction
{
    /**
     * @var Connector
     */
    private $connector;

    /**
     * RestartContainer constructor.
     * @param Connector $connector
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    public function handle(): void
    {
        $this->connector->ContainerResource()->containerRestart($this->data);
    }
}