<?php

namespace Dockent\Tests\components;

use Dockent\components\Controller;
use Dockent\Connector\Connector;
use PHPUnit\Framework\TestCase;

/**
 * Class ControllerTest
 * @package Dockent\Tests\components
 */
class ControllerTest extends TestCase
{
    /**
     * @var Controller
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new Controller();
    }

    public function testBeforeExecuteRoute()
    {
        $this->instance->beforeExecuteRoute();
        $docker = new \ReflectionProperty($this->instance, 'docker');
        $docker->setAccessible(true);
        $this->assertInstanceOf(Connector::class, $docker->getValue($this->instance));
    }
}