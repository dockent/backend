<?php

namespace Dockent\models\db\interfaces;
use Dockent\enums\NotificationStatus;
use Phalcon\Mvc\Model\ResultsetInterface;

/**
 * Interface INotifications
 * @package Dockent\models\db\interfaces
 */
interface INotifications
{
    /**
     * @param array $id
     * @return bool
     */
    public function deleteByIds(array $id): bool;

    /**
     * @param string $text
     * @param int $status
     * @return bool
     */
    public function createNotify(string $text, int $status = NotificationStatus::INFO): bool;

    /**
     * @return ResultsetInterface
     */
    public function getNotifications(): ResultsetInterface;
}