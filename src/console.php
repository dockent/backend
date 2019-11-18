<?php

use Dockent\components\ConsoleCommand;
use Dockent\console\Help;
use Dockent\exceptions\ConsoleCommandsNotFoundException;

require __DIR__ . '/bootstrap.php';

try {
    (new ConsoleCommand($di))->start();
} catch (ConsoleCommandsNotFoundException $e) {
    (new Help())->start();
}