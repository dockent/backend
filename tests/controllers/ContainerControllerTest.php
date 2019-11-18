<?php

namespace Dockent\Tests\controllers;

use Dockent\controllers\ContainerController;
use Dockent\Tests\mocks\Requests;
use Exception;
use Phalcon\Annotations\AdapterInterface;
use Phalcon\Di;
use Phalcon\Http\Response;
use Phalcon\Http\ResponseInterface;

/**
 * Class ContainerControllerTest
 *
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
     * @throws Exception
     */
    public function testIndexAction()
    {
        $result = $this->instance->indexAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
    }

    /**
     * @throws Exception
     */
    public function testCreateActionWithErrors()
    {
        $request = new Requests();
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
     * @throws Exception
     */
    public function testCreateActionWithoutErrors()
    {
        $request = new Requests();
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
     * @throws Exception
     */
    public function testStartAction()
    {
        $request = new Requests();
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
     * @throws Exception
     */
    public function testStopAction()
    {
        $request = new Requests();
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
     * @throws Exception
     */
    public function testRestartAction()
    {
        $request = new Requests();
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
     * @throws Exception
     */
    public function testRemoveAction()
    {
        $request = new Requests();
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
     * @throws Exception
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

    public function testViewAction404()
    {
        /** @var ResponseInterface|Response $result */
        $result = $this->instance->viewAction('view404');
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertEquals(404, $result->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testMethodAnnotations()
    {
        /** @var AdapterInterface $annotationsAdapter */
        $annotationsAdapter = Di::getDefault()->get(AdapterInterface::class);
        /**
         * POST methods
         */
        $methods = ['createAction', 'startAction', 'stopAction', 'restartAction'];
        foreach ($methods as $methodName) {
            $method = $annotationsAdapter->getMethod(ContainerController::class, $methodName);
            $this->assertTrue($method->has('Method'));
            $this->assertEquals(['POST'], $method->get('Method')->getArguments());
        }
        /**
         * DELETE methods
         */
        $methods = ['removeAction'];
        foreach ($methods as $methodName) {
            $method = $annotationsAdapter->getMethod(ContainerController::class, $methodName);
            $this->assertTrue($method->has('Method'));
            $this->assertEquals(['DELETE'], $method->get('Method')->getArguments());
        }
    }
}