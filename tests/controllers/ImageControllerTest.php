<?php

namespace Dockent\Tests\controllers;

use Dockent\components\DI as DIFactory;
use Dockent\controllers\ImageController;
use Dockent\enums\DI;
use Dockent\Tests\mocks\Requests;
use Phalcon\Annotations\AdapterInterface;
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
        /** @var Requests $request */
        $request = DIFactory::getDI()->get(DI::REQUEST);
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
        /** @var Requests $request */
        $request = DIFactory::getDI()->get(DI::REQUEST);
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
    public function testForceRemoveAction()
    {
        /** @var Requests $request */
        $request = DIFactory::getDI()->get(DI::REQUEST);
        $request->setRawBody('{"id":["remove_action"]}');
        $this->instance->request = $request;
        $result = $this->instance->forceRemoveAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
    }
}