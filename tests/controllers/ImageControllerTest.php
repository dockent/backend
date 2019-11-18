<?php

namespace Dockent\Tests\controllers;

use Dockent\controllers\ImageController;
use Dockent\Tests\mocks\Requests;
use Exception;
use Phalcon\Annotations\AdapterInterface;
use Phalcon\Di;
use Phalcon\Http\ResponseInterface;

/**
 * Class ImageControllerTest
 * @package Dockent\Tests\controllers
 */
class ImageControllerTest extends ControllerTestCase
{
    /**
     * @var ImageController
     */
    private $instance;

    public function setUp()
    {
        parent::setUp();
        $this->instance = new ImageController();
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
     * @throws Exception
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
     * @throws Exception
     */
    public function testForceRemoveAction()
    {
        $request = new Requests();
        $request->setRawBody('{"id":["remove_action"]}');
        $this->instance->request = $request;
        $result = $this->instance->forceRemoveAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
    }

    /**
     * @throws Exception
     */
    public function testMethodAnnotations()
    {
        /** @var AdapterInterface $annotationsAdapter */
        $annotationsAdapter = Di::getDefault()->get(AdapterInterface::class);
        $methods = ['removeAction', 'forceRemoveAction'];
        foreach ($methods as $methodName) {
            $method = $annotationsAdapter->getMethod(ImageController::class, $methodName);
            $this->assertTrue($method->has('Method'));
            $this->assertEquals(['DELETE'], $method->get('Method')->getArguments());
        }
    }
}