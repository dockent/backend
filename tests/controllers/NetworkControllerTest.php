<?php

namespace Dockent\Tests\controllers;

use Dockent\controllers\NetworkController;
use Dockent\Tests\mocks\Requests;
use Phalcon\Annotations\AdapterInterface;
use Phalcon\Di;
use Phalcon\Http\Response;
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
    public function testRemoveAction()
    {
        $request = new Requests();
        $request->setRawBody('{"id":["remove_action"]}');
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
    public function testRemoveActionWithException()
    {
        $request = new Requests();
        $request->setRawBody('{"id":["exception"]}');
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
    }

    public function testViewAction404()
    {
        /** @var ResponseInterface|Response $result */
        $result = $this->instance->viewAction('view404');
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertEquals(404, $result->getStatusCode());
    }

    /**
     * @throws \Exception
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
     * @throws \Exception
     */
    public function testCreateActionWithoutErrors()
    {
        $request = new Requests();
        $request->setRawBody('{"Name": "test"}');
        $this->instance->request = $request;
        $result = $this->instance->createAction();
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
        $annotationsAdapter = Di::getDefault()->get(AdapterInterface::class);
        /**
         * POST methods
         */
        $methods = ['createAction'];
        foreach ($methods as $methodName) {
            $method = $annotationsAdapter->getMethod(NetworkController::class, $methodName);
            $this->assertTrue($method->has('Method'));
            $this->assertEquals(['POST'], $method->get('Method')->getArguments());
        }
        /**
         * DELETE methods
         */
        $methods = ['removeAction'];
        foreach ($methods as $methodName) {
            $method = $annotationsAdapter->getMethod(NetworkController::class, $methodName);
            $this->assertTrue($method->has('Method'));
            $this->assertEquals(['DELETE'], $method->get('Method')->getArguments());
        }
    }
}