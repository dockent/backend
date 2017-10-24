<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 24.10.17
 * Time: 15:53
 */

namespace Dockent\components;

/**
 * Interface Configurable
 * @package Dockent\components
 */
interface Configurable
{
    /**
     * @return array
     */
    public function pasteToConfig(): array;
}