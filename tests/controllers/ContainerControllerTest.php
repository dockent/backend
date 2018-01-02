<?php

namespace Dockent\Tests\controllers;

use Dockent\components\DI as DIFactory;
use Dockent\controllers\ContainerController;
use Dockent\enums\DI;
use Phalcon\Annotations\AdapterInterface;
use Phalcon\Http\ResponseInterface;

/**
 * Class ContainerControllerTest
 * @package Dockent\Tests\controllers
 */
class ContainerControllerTest extends ControllerTestCase
{
    /**
     * @var ContainerController
     */
    private $instance;

    public function setUp()
    {
        parent::setUp();
        $this->instance = new ContainerController();
        $this->instance->beforeExecuteRoute();
    }

    public function testIndexAction()
    {
        $result = $this->instance->indexAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
    }

    public function testCreateActionWithErrors()
    {
        $result = $this->instance->createAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('error', $encodedResult['status']);
        $this->assertArrayHasKey('errors', $encodedResult);
        $this->assertInternalType('array', $encodedResult['errors']);
        $this->assertNotEmpty($encodedResult['errors']);
    }

    public function testCreateActionWithoutErrors()
    {
        $_POST = [
            'Image' => 'busybox'
        ];
        $result = $this->instance->createAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
        $this->assertArrayHasKey('message', $encodedResult);
        $this->assertEquals('Action sent to queue', $encodedResult['message']);
    }

    public function testStartAction()
    {
        $result = $this->instance->startAction('start_action');
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
    }

    /**
     * @throws \Phalcon\Http\Request\Exception
     */
    public function testStartActionBulk()
    {
        $_POST = [
            'id' => [1]
        ];
        $this->expectOutputString('');
        $this->instance->bulkAction('start');
    }

    public function testStopAction()
    {
        $result = $this->instance->stopAction('stop_action');
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
        $this->assertArrayHasKey('message', $encodedResult);
        $this->assertEquals('Action sent to queue', $encodedResult['message']);
    }

    /**
     * @throws \Phalcon\Http\Request\Exception
     */
    public function testStopActionBulk()
    {
        $_POST = [
            'id' => [1]
        ];
        $this->expectOutputString('');
        $this->instance->bulkAction('stop');
    }

    public function testRestartAction()
    {
        $result = $this->instance->restartAction('restart_action');
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
        $this->assertArrayHasKey('message', $encodedResult);
        $this->assertEquals('Action sent to queue', $encodedResult['message']);
    }

    /**
     * @throws \Phalcon\Http\Request\Exception
     */
    public function testRestartActionBulk()
    {
        $_POST = [
            'id' => [1]
        ];
        $this->expectOutputString('');
        $this->instance->bulkAction('restart');
    }

    public function testRemoveAction()
    {
        $result = $this->instance->removeAction('remove_action');
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
    }

    /**
     * @throws \Phalcon\Http\Request\Exception
     */
    public function testRemoveActionBulk()
    {
        $_POST = [
            'id' => [1]
        ];
        $this->expectOutputString('');
        $this->instance->bulkAction('remove');
    }

    public function testViewAction()
    {
        $result = $this->instance->viewAction('view_action');
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('top', $encodedResult);
        $this->assertArrayHasKey('model', $encodedResult);
    }

    public function testRenameActionWithErrors()
    {
        $result = $this->instance->renameAction('rename_action');
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('error', $encodedResult['status']);
        $this->assertArrayHasKey('errors', $encodedResult);
        $this->assertInternalType('array', $encodedResult['errors']);
        $this->assertNotEmpty($encodedResult['errors']);
    }

    public function testRenameActionWithoutErrors()
    {
        $_POST = [
            'name' => 'test'
        ];
        $result = $this->instance->renameAction('rename_action');
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
    }

    public function testMethodAnnotations()
    {
        /** @var AdapterInterface $annotationsAdapter */
        $annotationsAdapter = DIFactory::getDI()->get(DI::ANNOTATIONS);
        $methods = ['createAction', 'renameAction'];
        foreach ($methods as $methodName) {
            $method = $annotationsAdapter->getMethod(ContainerController::class, $methodName);
            $this->assertTrue($method->has('Method'));
            $this->assertEquals(['POST'], $method->get('Method')->getArguments());
        }
    }

    public function testBulkAnnotations()
    {
        /** @var AdapterInterface $annotationsAdapter */
        $annotationsAdapter = DIFactory::getDI()->get(DI::ANNOTATIONS);
        $methods = ['startAction', 'stopAction', 'restartAction', 'removeAction'];
        foreach ($methods as $methodName) {
            $method = $annotationsAdapter->getMethod(ContainerController::class, $methodName);
            $this->assertTrue($method->has('Bulk'));
        }
    }

    public function tearDown()
    {
        $_POST = [];
    }
}