<?php

namespace Dockent\models\db;

use Dockent\enums\NotificationStatus;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\ResultsetInterface;

/**
 * Class Notifications
 * @package Dockent\models\db
 */
class Notifications extends Model implements NotificationsInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var bool
     */
    protected $viewed = false;

    /**
     * @var int
     * @see NotificationStatus
     */
    protected $status;

    /**
     * @var int
     */
    protected $time;

    public function initialize(): void
    {
        $this->setSource($this->getTableName());
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return bool
     */
    public function isViewed(): bool
    {
        return $this->viewed;
    }

    /**
     * @param bool $viewed
     */
    public function setViewed(bool $viewed): void
    {
        $this->viewed = $viewed;
    }

    /**
     * @return int
     * @see NotificationStatus
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @see NotificationStatus
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }

    /**
     * @param int $time
     */
    public function setTime(int $time): void
    {
        $this->time = $time;
    }

    /**
     * @param array $id
     * @return bool
     */
    public function deleteByIds(array $id): bool
    {
        return $this->getWriteConnection()->delete($this->getTableName(), 'id = ?', $id);
    }

    /**
     * @param string $text
     * @param int $status
     * @return bool
     */
    public function createNotify(string $text, int $status = NotificationStatus::INFO): bool
    {
        $notify = new self();
        $notify->setText($text);
        $notify->setStatus($status);
        $notify->setTime(time());
        return $notify->save();
    }

    /**
     * @param bool $changeStatus
     * @return ResultsetInterface
     */
    public function getNotifications(bool $changeStatus = true): ResultsetInterface
    {
        $notifications = static::find();
        if ($changeStatus) {
            $this->getWriteConnection()->update($this->getSource(), ['viewed'], [true]);
        }
        return $notifications;
    }

    /**
     * @param int $id
     */
    public function markAsUnread(int $id): void
    {
        $this->getWriteConnection()->update($this->getSource(), ['viewed'], [false], 'id = ' . (int)$id);
    }

    /**
     * @return int
     */
    public function getUnreadCount(): int
    {
        return static::count(['viewed' =>  0]);
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return 'notifications';
    }
}