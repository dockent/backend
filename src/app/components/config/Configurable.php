<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 24.10.17
 * Time: 15:53
 */

namespace Dockent\components\config;

/**
 * Interface Configurable
 * @package Dockent\components\config
 */
interface Configurable
{
    /**
     * @return array
     */
    public function pasteToConfig(): array;

    /**
     * @return bool
     */
    public function afterSave(): bool;
}