<?php

namespace Dockent\models\db;

use Dockent\components\DI as DIFactory;
use Dockent\enums\DI;
use Dockent\enums\TableName;
use Phalcon\Db\AdapterInterface;
use Phalcon\Mvc\Model;

/**
 * Class Notifications
 * @package Dockent\models\db
 */
class Notifications extends Model
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
     * @param array $id
     * @return bool
     */
    public static function deleteByIds(array $id): bool
    {
        /** @var AdapterInterface $dbConnection */
        $dbConnection = DIFactory::getDI()->get(DI::DB);
        return $dbConnection->delete(TableName::NOTIFICATIONS, 'id = ?', $id);
    }

    /**
     * @param string $text
     * @return bool
     */
    public static function createNotify(string $text): bool
    {
        $notify = new self();
        $notify->setText($text);
        return $notify->save();
    }
}