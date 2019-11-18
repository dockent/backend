<?php

namespace Dockent\console;

use Dockent\components\ConsoleCommand;

/**
 * Class Help
 * @package Dockent\console
 */
class Help implements ConsoleCommandInterface
{
    public function start(): void
    {
        $commands = ConsoleCommand::findCommands();
        foreach ($commands as $command) {
            echo $command . PHP_EOL;
        }
    }
}