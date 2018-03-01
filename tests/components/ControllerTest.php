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

    /**
     * @throws \Exception
     * @throws \ReflectionException
     */
    public function testDockerInstanceCreate()
    {
        $this->instance->beforeExecuteRoute();
        $docker = new \ReflectionProperty($this->instance, 'docker');
        $docker->setAccessible(true);
        $this->assertInstanceOf(Connector::class, $docker->getValue($this->instance));
    }

    /**
     * @throws \Exception
     */
    public function testDebugModeEnabled()
    {
        $this->assertFalse(Controller::$DEBUG_MODE);
        putenv('DOCKENT_DEBUG=true');
        $this->instance->beforeExecuteRoute();
        $this->assertTrue(Controller::$DEBUG_MODE);
    }

    /**
     * @throws \Exception
     */
    public function testCorsHeaders()
    {
        $this->instance->beforeExecuteRoute();
        $this->assertEquals('*', $this->instance->response->getHeaders()->get('Access-Control-Allow-Origin'));
    }
}