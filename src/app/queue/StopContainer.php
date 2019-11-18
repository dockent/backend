<?php

namespace Dockent\queue;

use Dockent\Connector\Connector;

/**
 * Class StopContainer
 * @package Dockent\queue
 */
class StopContainer extends QueueAction
{
    /**
     * @var Connector
     */
    private $connector;

    /**
     * StopContainer constructor.
     * @param Connector $connector
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    public function handle(): void
    {
        $this->connector->ContainerResource()->containerStop($this->data);
    }
}