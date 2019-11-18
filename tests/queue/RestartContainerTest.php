<?php

namespace Dockent\Tests\queue;

use Dockent\queue\RestartContainer;
use Dockent\Tests\mocks\Connector;
use PHPUnit\Framework\TestCase;

/**
 * Class RestartContainerTest
 *
 * @package Dockent\Tests\queue
 */
class RestartContainerTest extends TestCase
{
    /**
     * @var RestartContainer
     */
    private $instance;

    protected function setUp()
    {
        $this->instance = new RestartContainer(new Connector());
    }

    public function testHandle()
    {
        $this->expectOutputString('');
        $this->instance->handle();
    }
}