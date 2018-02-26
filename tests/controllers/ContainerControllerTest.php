<?php

namespace Dockent\Tests\controllers;

use Dockent\components\DI as DIFactory;
use Dockent\controllers\ContainerController;
use Dockent\enums\DI;
use Dockent\Tests\mocks\Requests;
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

    /**
     * @throws \Exception
     */
    public function testIndexAction()
    {
        $result = $this->instance->indexAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
    }

    /**
     * @throws \Exception
     */
    public function testCreateActionWithErrors()
    {
        /** @var Requests $request */
        $request = DIFactory::getDI()->get(DI::REQUEST);
        $request->setRawBody('{}');
        $this->instance->request = $request;
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

    /**
     * @throws \Exception
     */
    public function testCreateActionWithoutErrors()
    {
        /** @var Requests $request */
        $request = DIFactory::getDI()->get(DI::REQUEST);
        $request->setRawBody('{"Image":"busybox"}');
        $this->instance->request = $request;
        $result = $this->instance->createAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
        $this->assertArrayHasKey('message', $encodedResult);
        $this->assertEquals('Action sent to queue', $encodedResult['message']);
    }

    /**
     * @throws \Exception
     */
    public function testStartAction()
    {
        /** @var Requests $request */
        $request = DIFactory::getDI()->get(DI::REQUEST);
        $request->setRawBody('{"id":["d7e6b38e07ca2a64e0ac7a9ebf3c0abfe4af27fc6646e9d20b1d33d5835fe0c1"]}');
        $this->instance->request = $request;
        $result = $this->instance->startAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
    }

    /**
     * @throws \Exception
     */
    public function testStopAction()
    {
        /** @var Requests $request */
        $request = DIFactory::getDI()->get(DI::REQUEST);
        $request->setRawBody('{"id":["d7e6b38e07ca2a64e0ac7a9ebf3c0abfe4af27fc6646e9d20b1d33d5835fe0c1"]}');
        $this->instance->request = $request;
        $result = $this->instance->stopAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
        $this->assertArrayHasKey('message', $encodedResult);
        $this->assertEquals('Action sent to queue', $encodedResult['message']);
    }

    /**
     * @throws \Exception
     */
    public function testRestartAction()
    {
        /** @var Requests $request */
        $request = DIFactory::getDI()->get(DI::REQUEST);
        $request->setRawBody('{"id":["d7e6b38e07ca2a64e0ac7a9ebf3c0abfe4af27fc6646e9d20b1d33d5835fe0c1"]}');
        $this->instance->request = $request;
        $result = $this->instance->restartAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
        $this->assertArrayHasKey('message', $encodedResult);
        $this->assertEquals('Action sent to queue', $encodedResult['message']);
    }

    /**
     * @throws \Exception
     */
    public function testRemoveAction()
    {
        /** @var Requests $request */
        $request = DIFactory::getDI()->get(DI::REQUEST);
        $request->setRawBody('{"id":["d7e6b38e07ca2a64e0ac7a9ebf3c0abfe4af27fc6646e9d20b1d33d5835fe0c1"]}');
        $this->instance->request = $request;
        $result = $this->instance->removeAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
    }

    /**
     * @throws \Exception
     */
    public function testViewAction()
    {
        $result = $this->instance->viewAction('view_action');
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('top', $encodedResult);
        $this->assertArrayHasKey('model', $encodedResult);
    }

    /**
     * @throws \Exception
     */
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

    /**
     * @throws \Exception
     */
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

    /**
     * @throws \Exception
     */
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

    public function tearDown()
    {
        $_POST = [];
    }
}