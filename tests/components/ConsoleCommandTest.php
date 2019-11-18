<?php

namespace Dockent\Tests\components;

use Dockent\components\ConsoleCommand;
use Phalcon\Di;
use PHPUnit\Framework\TestCase;

class ConsoleCommandTest extends TestCase
{
    /**
     * @var ConsoleCommand
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new ConsoleCommand(Di::getDefault());
    }

    public function testStartWithoutCommand()
    {
        $this->expectOutputString('HealthCheck
Help
Queue
');
        $this->instance->start();
    }

    public function testStartWithHealthCheck()
    {
        $this->expectOutputString('Ok' . PHP_EOL);
        $_SERVER['argv'][1] = 'HealthCheck';
        $this->instance->start();
    }
}
