<?php

namespace Dockent\models\db;

use Dockent\components\DI as DIFactory;
use Dockent\enums\DI;
use Dockent\enums\NotificationStatus;
use Dockent\enums\TableName;
use Dockent\models\db\interfaces\INotifications;
use Phalcon\Db\AdapterInterface;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\ResultsetInterface;

/**
 * Class Notifications
 * @package Dockent\models\db
 */
class Notifications extends Model implements INotifications
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
    protected $viewed;

    /**
     * @var int
     * @see NotificationStatus
     */
    protected $status;

    /**
     * @var int
     */
    protected $time;

    public function initialize()
    {
        $this->setSource(TableName::NOTIFICATIONS);
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
    public function setId(int $id)
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
    public function setText(string $text)
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
    public function setViewed(bool $viewed)
    {
        $this->viewed = $viewed;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status)
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
    public function setTime(int $time)
    {
        $this->time = $time;
    }

    /**
     * @param array $id
     * @return bool
     */
    public function deleteByIds(array $id): bool
    {
        /** @var AdapterInterface $dbConnection */
        $dbConnection = DIFactory::getDI()->get(DI::DB);
        return $dbConnection->delete(TableName::NOTIFICATIONS, 'id = ?', $id);
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
     * @return ResultsetInterface
     */
    public function getNotifications(): ResultsetInterface
    {
        $notifications = static::find();
        $this->getWriteConnection()->update($this->getSource(), ['viewed'], [true]);
        return $notifications;
    }
}