<?php

namespace Dockent\Tests\controllers;

use Dockent\components\DI as DIFactory;
use Dockent\controllers\ImageController;
use Dockent\enums\DI;
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

    public function testForceRemoveAction()
    {
        $result = $this->instance->forceRemoveAction('force_remove_action');
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
    }

    /**
     * @throws \Phalcon\Http\Request\Exception
     */
    public function testForceRemoveActionBulk()
    {
        $_POST = [
            'id' => [1]
        ];
        $this->expectOutputString('');
        $this->instance->bulkAction('forceRemove');
    }

    public function testBulkAnnotations()
    {
        /** @var AdapterInterface $annotationsAdapter */
        $annotationsAdapter = DIFactory::getDI()->get(DI::ANNOTATIONS);
        $methods = ['removeAction', 'forceRemoveAction'];
        foreach ($methods as $methodName) {
            $method = $annotationsAdapter->getMethod(ImageController::class, $methodName);
            $this->assertTrue($method->has('Bulk'));
        }
    }

    public function tearDown()
    {
        $_POST = [];
    }
}