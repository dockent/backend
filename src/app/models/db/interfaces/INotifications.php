<?php

namespace Dockent\models\db\interfaces;

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
     * @return bool
     */
    public function createNotify(string $text): bool;
}