<?php

namespace Dockent\models\db;

use Dockent\enums\NotificationStatus;
use Phalcon\Mvc\Model\ResultsetInterface;

/**
 * Interface INotifications
 * @package Dockent\models\db\interfaces
 */
interface NotificationsInterface
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
     * @param bool $changeStatus
     * @return ResultsetInterface
     */
    public function getNotifications(bool $changeStatus = true): ResultsetInterface;

    /**
     * @param int $id
     */
    public function markAsUnread(int $id): void;

    /**
     * @return int
     */
    public function getUnreadCount(): int;
}