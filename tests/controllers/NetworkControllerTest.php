<?php

namespace Dockent\Tests\controllers;

use Dockent\components\DI as DIFactory;
use Dockent\controllers\NetworkController;
use Dockent\enums\DI;
use Phalcon\Annotations\AdapterInterface;
use Phalcon\Http\ResponseInterface;

/**
 * Class NetworkControllerTest
 * @package Dockent\Tests\controllers
 */
class NetworkControllerTest extends ControllerTestCase
{
    /**
     * @var NetworkController
     */
    private $instance;

    public function setUp()
    {
        parent::setUp();
        $this->instance = new NetworkController();
        $this->instance->beforeExecuteRoute();
    }

    public function testIndexAction()
    {
        $result = $this->instance->indexAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
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

    public function testRemoveActionWithException()
    {
        $result = $this->instance->removeAction('exception');
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
            'Name' => 'test'
        ];
        $result = $this->instance->createAction();
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
        $methods = ['createAction'];
        foreach ($methods as $methodName) {
            $method = $annotationsAdapter->getMethod(NetworkController::class, $methodName);
            $this->assertTrue($method->has('Method'));
            $this->assertEquals(['POST'], $method->get('Method')->getArguments());
        }
    }

    public function testBulkAnnotations()
    {
        /** @var AdapterInterface $annotationsAdapter */
        $annotationsAdapter = DIFactory::getDI()->get(DI::ANNOTATIONS);
        $methods = ['removeAction'];
        foreach ($methods as $methodName) {
            $method = $annotationsAdapter->getMethod(NetworkController::class, $methodName);
            $this->assertTrue($method->has('Bulk'));
        }
    }

    public function tearDown()
    {
        $_POST = [];
    }
}