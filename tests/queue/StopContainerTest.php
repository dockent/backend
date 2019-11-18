<?php

namespace Dockent\Tests\queue;

use Dockent\queue\StopContainer;
use Dockent\Tests\mocks\Connector;
use PHPUnit\Framework\TestCase;

/**
 * Class StopContainerTest
 *
 * @package Dockent\Tests\queue
 */
class StopContainerTest extends TestCase
{
    /**
     * @var StopContainer
     */
    private $instance;

    protected function setUp()
    {
        $this->instance = new StopContainer(new Connector());
    }

    public function testHandle()
    {
        $this->expectOutputString('');
        $this->instance->handle();
    }
}