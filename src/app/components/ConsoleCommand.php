<?php

namespace Dockent\components;

use Dockent\console\ConsoleCommandInterface;
use Phalcon\DiInterface;

/**
 * Class ConsoleCommand
 * @package Dockent\components
 */
class ConsoleCommand implements ConsoleCommandInterface
{
    /**
     * @var DiInterface
     */
    private $di;

    /**
     * ConsoleCommand constructor.
     * @param DiInterface $di
     */
    public function __construct(DiInterface $di)
    {
        $this->di = $di;
    }

    public function start(): void
    {
        $commands = static::findCommands();
        if (!isset($_SERVER['argv'][1]) || !in_array($_SERVER['argv'][1], $commands)) {
            $_SERVER['argv'][1] = 'Help';
        }
        $class = '\Dockent\console\\' . $_SERVER['argv'][1];
        /** @var ConsoleCommandInterface $instance */
        $instance = $this->di->get($class);
        $instance->start();
    }

    /**
     * @return array
     */
    public static function findCommands(): array
    {
        $scanCommands = scandir(__DIR__ . '/../console');
        $ignore = ['.', '..', 'ConsoleCommandInterface.php'];
        return array_map(function ($item) {
            return substr($item, 0, -4);
        }, array_filter($scanCommands, function ($item) use ($ignore) {
            return !in_array($item, $ignore);
        }));
    }
}