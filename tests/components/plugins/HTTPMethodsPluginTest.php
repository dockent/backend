<?php

namespace Dockent\Tests\components\plugins;

use Dockent\components\DI as DIFactory;
use Dockent\components\plugins\HTTPMethodsPlugin;
use Dockent\enums\DI;
use Dockent\enums\Events;
use Dockent\Tests\mocks\Requests;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use PHPUnit\Framework\TestCase;

/**
 * Class HTTPMethodsPluginTest
 * @package Dockent\Tests\components\plugins
 */
class HTTPMethodsPluginTest extends TestCase
{
    /**
     * @var HTTPMethodsPlugin
     */
    private $instance;

    /**
     * @var Event
     */
    private $event;

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @var Requests
     */
    private $request;

    public function setUp()
    {
        $this->instance = new HTTPMethodsPlugin();
        $this->event = new Event(Events::DISPATCH_BEFORE_EXECUTE_ROUTE, $this);
        $this->dispatcher = new Dispatcher();
        $this->dispatcher->setDefaultNamespace('Dockent\Tests\mocks');
        $this->dispatcher->setControllerName('Test');
        DIFactory::getDI()->set(DI::REQUEST, new Requests());
        $this->request = DIFactory::getDI()->get(DI::REQUEST);
    }

    public function testWithoutMethod()
    {
        $this->assertTrue($this->instance->beforeExecuteRoute($this->event, $this->dispatcher));
    }

    public function testOnlyGetMethod()
    {
        $this->assertTrue($this->instance->beforeExecuteRoute($this->event, $this->dispatcher));
    }

    public function testOnlyPostMethod()
    {
        $this->dispatcher->setActionName('onlyPost');
        $this->assertFalse($this->instance->beforeExecuteRoute($this->event, $this->dispatcher));
        $this->request->setPost();
        $this->assertTrue($this->instance->beforeExecuteRoute($this->event, $this->dispatcher));
    }

    public function testOnlyPutMethod()
    {
        $this->dispatcher->setActionName('onlyPut');
        $this->assertFalse($this->instance->beforeExecuteRoute($this->event, $this->dispatcher));
        $this->request->setPut();
        $this->assertTrue($this->instance->beforeExecuteRoute($this->event, $this->dispatcher));
    }

    public function testOnlyDeleteMethod()
    {
        $this->dispatcher->setActionName('onlyDelete');
        $this->assertFalse($this->instance->beforeExecuteRoute($this->event, $this->dispatcher));
        $this->request->setDelete();
        $this->assertTrue($this->instance->beforeExecuteRoute($this->event, $this->dispatcher));
    }

    public function testFewMethods()
    {
        $this->dispatcher->setActionName('fewMethods');
        $this->assertTrue($this->instance->beforeExecuteRoute($this->event, $this->dispatcher));
        $this->request->setPost();
        $this->assertTrue($this->instance->beforeExecuteRoute($this->event, $this->dispatcher));
        $this->request->setPut();
        $this->assertFalse($this->instance->beforeExecuteRoute($this->event, $this->dispatcher));
        $this->request->setDelete();
        $this->assertFalse($this->instance->beforeExecuteRoute($this->event, $this->dispatcher));
    }
}