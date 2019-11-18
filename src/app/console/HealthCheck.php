<?php

namespace Dockent\console;

/**
 * Class HealthCheck
 * @package Dockent\console
 *
 * Used only for Unit tests
 */
class HealthCheck implements ConsoleCommandInterface
{
    public function start(): void
    {
        echo 'Ok' . PHP_EOL;
    }
}