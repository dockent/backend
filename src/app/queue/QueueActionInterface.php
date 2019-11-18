<?php

namespace Dockent\queue;

/**
 * Interface QueueActionInterface
 * @package Dockent\queue
 */
interface QueueActionInterface
{
    /**
     * @param $data
     * @return QueueActionInterface
     */
    public function setData($data): self;

    public function handle(): void;
}