<?php

namespace Dockent\queue;

/**
 * Class QueueAction
 *
 * @package Dockent\queue
 */
abstract class QueueAction implements QueueActionInterface
{
    /**
     * @var
     */
    protected $data;

    /**
     * @param $data
     * @return QueueActionInterface
     */
    public function setData($data): QueueActionInterface
    {
        $this->data = $data;

        return $this;
    }
}