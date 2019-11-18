<?php

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